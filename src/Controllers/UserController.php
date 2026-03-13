<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

use AnthonyEdmonds\LaravelFormBuilder\Helpers\Field;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use NetworkRailBusinessSystems\Common\FormRequests\ImportUserRequest;
use NetworkRailBusinessSystems\Common\Helpers\Csv;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\ResourceCollections\UserCollection;
use NetworkRailBusinessSystems\Common\ResourceCollections\UserRoleCollection;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    public function index(): View
    {
        $userModel = $this->newUserModel();

        $this->authorize(
            config('common.permissions.manage_users'),
            $userModel,
        );

        return view('common::admin.users.index', [
            'breadcrumbs' => [
                'Admin' => route('admin.index'),
                'Users' => route('admin.users.index'),
            ],
            'title' => 'Manage Users',
            'users' => UserCollection::make(
                $userModel->query()
                    ->with(['roles'])
                    ->paginate(),
            ),
        ]);
    }

    public function create(): View
    {
        $this->authorize(
            config('common.permissions.manage_users'),
            $this->newUserModel(),
        );

        return view('common::admin.users.create', [
            'action' => route('admin.users.create'),
            'back' => route('admin.users.index'),
            'fields' => [
                Field::input('email', 'What is their e-mail address?')
                    ->setHint('Enter their complete e-mail address including the domain')
                    ->setWidth(20),
            ],
            'title' => 'Import User',
        ]);
    }

    public function store(ImportUserRequest $request): RedirectResponse
    {
        $this->authorize(
            config('common.permissions.manage_users'),
            $this->newUserModel(),
        );

        /** @var ?User $user */
        $user = EntraUser::import(
            $request->input('email'),
        );

        if ($user === null) {
            flash()->error('Enter the e-mail of a person with a Network Rail account');

            return redirect()->route('admin.users.create');
        }

        flash()->success("The account for $user->name was successfully created");

        return redirect()->route('admin.users.show', $user);
    }

    public function show(User $user): View
    {
        $this->authorize(
            config('common.permissions.manage_users'),
            $user,
        );

        return view('common::admin.users.show', [
            'breadcrumbs' => [
                'Admin' => route('admin.index'),
                'Users' => route('admin.users.index'),
                $user->name => route('admin.users.show', $user),
            ],
            'roles' => UserRoleCollection::make(
                Role::query()->get(),
            ),
            'title' => "Manage $user->name",
            'user' => $user,
        ]);
    }

    public function export(): BinaryFileResponse
    {
        $this->authorize(
            config('common.permissions.manage_users'),
            $this->newUserModel(),
        );

        return Csv::export(
            mb_strtolower(config('app.acronym')) . '_users.csv',
            DB::table('users')
                ->select([
                    'users.id AS id',
                    DB::raw('MAX(users.name) AS name'),
                    DB::raw('MAX(users.email) AS email'),
                    DB::raw('MAX(users.updated_at) AS last_login'),
                    DB::raw('GROUP_CONCAT(roles.name, ",") AS roles'),
                ])
                ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->groupBy('users.id')
                ->orderBy('users.name')
                ->get(),
        );
    }

    protected function newUserModel(): User
    {
        /** @var class-string<User> $userClass */
        $userClass = config('common.models.user');
        return new $userClass();
    }
}

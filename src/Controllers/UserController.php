<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

use AnthonyEdmonds\LaravelFormBuilder\Helpers\Field;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use NetworkRailBusinessSystems\Common\Finders\UserFinder;
use NetworkRailBusinessSystems\Common\FormRequests\ImportUserRequest;
use NetworkRailBusinessSystems\Common\Helpers\Csv;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\ResourceCollections\UserRoleCollection;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    public function __construct()
    {
        app()->bind(User::class, config('common.models.user'));
    }

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
            'finder' => UserFinder::find(),
            'title' => 'Manage Users',
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
        $userModel = $this->newUserModel();

        $this->authorize(
            config('common.permissions.manage_users'),
            $userModel,
        );

        $finder = new UserFinder();

        $rolesTable = config('permission.table_names.roles');
        $modelHasRolesTable = config('permission.table_names.model_has_roles');
        $modelColumn = config('permission.column_names.model_morph_key');

        $users = DB::table('users AS results')
            ->select([
                'results.id AS id',
                DB::raw('MAX(results.name) AS name'),
                DB::raw('MAX(results.email) AS email'),
                DB::raw('MAX(results.updated_at) AS last_login'),
                DB::raw("GROUP_CONCAT($rolesTable.name, \",\") AS roles"),
            ])
            ->leftJoin(
                $modelHasRolesTable,
                "$modelHasRolesTable.$modelColumn",
                '=',
                'results.id',
            )
            ->leftJoin(
                $rolesTable,
                "$rolesTable.id",
                '=',
                "$modelHasRolesTable.$modelColumn",
            )
            ->whereExists(
                $userModel::query()
                    ->index(
                        $finder->currentSearch,
                        $finder->currentFilter,
                    )
                    ->whereColumn('users.id', '=', 'results.id'),
            )
            ->groupBy('results.id')
            ->orderBy('results.name')
            ->get();

        return Csv::export(
            mb_strtolower(config('app.acronym')) . '_users.csv',
            $users,
        );
    }

    protected function newUserModel(): User
    {
        /** @var class-string<User> $userClass */
        $userClass = config('common.models.user');
        return new $userClass();
    }
}

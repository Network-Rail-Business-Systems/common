<?php

namespace NetworkRailBusinessSystems\Common\Controllers\User;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use NetworkRailBusinessSystems\Common\Controllers\Controller;
use NetworkRailBusinessSystems\Common\Csv;
use NetworkRailBusinessSystems\Common\FormRequests\ImportUserRequest;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\ResourceCollections\UserCollection;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    public function index(): View
    {
        $this->authorize('manage', new User());

        return view('common::users.index', [
            'breadcrumbs' => [
                'Admin' => route('admin.dashboard'),
                'Users' => route('common.users.index'),
            ],
            'title' => 'Manage Users',
            'users' => UserCollection::make(
                User::with(['roles'])->paginate(),
            ),
        ]);
    }

    public function create(): View
    {
        $this->authorize('manage', new User());

        return view('common::users.create', [
            'action' => route('common.users.create'),
            'back' => route('common.users.index'),
            'fields' => [
                Field::input('email', 'What is their e-mail address?')
                    ->hint('Enter their complete e-mail address including @networkrail.co.uk')
                    ->width(20),
            ],
            'title' => 'Import',
        ]);
    }

    public function store(ImportUserRequest $request): RedirectResponse
    {
        $this->authorize('manage', new User());

        /** @var ?User $user */
        $user = EntraUser::import(
            $request->input('email'),
        );

        if ($user === null) {
            flash()->error('Enter the e-mail of a person with a Network Rail account');

            return redirect()->route('admin.users.create');
        }

        flash()->success("The account for $user->name was successfully created.");

        return redirect()->route('common.users.show', $user);
    }

    public function show(User $user): View
    {
        $this->authorize('manage', $user);
        /** @var User $viewer */
        $viewer = Auth::user();

        $roles = Role::query()
            ->get()
            ->map(function (Role $role) use ($user, $viewer) {
                $hasRole = $user->hasRole($role) === true;

                return [
                    'name' => $role->name,
                    'status' => $hasRole === true ? 'Active' : 'Inactive',
                    'colour' => $hasRole === true ? 'blue' : 'grey',
                    'action' => $hasRole === true ? 'Revoke' : 'Grant',
                    'link' => $hasRole === true
                        ? route('common.users.roles.revoke', [$user, $role])
                        : route('common.users.roles.grant', [$user, $role]),
                    'hide' => $viewer->can('grant', [$user, $role]) === false
                        ? 1
                        : 0,
                ];
            });

        return view('common::users.show', [
            'action' => route('admin.users.create'),
            'back' => route('admin.users.index'),
            'breadcrumbs' => [
                'Admin' => route('admin.dashboard'),
                'Users' => route('admin.users.index'),
                $user->name => route('admin.users.show', $user),
            ],
            'roles' => $roles,
            'title' => "Manage $user->name",
            'user' => $user->load(['permissions', 'roles']),
        ]);
    }

    public function export(): BinaryFileResponse
    {
        $this->authorize('manage', new User());

        return Csv::export(
            config('app.acronym') . '-users.csv',
            DB::table('users')
                ->select([
                    'users.id AS id',
                    DB::raw('MAX(users.name) AS name'),
                    DB::raw('MAX(users.email) AS email'),
                    DB::raw('MAX(users.updated_at) AS last_login'),
                    DB::raw('GROUP_CONCAT(roles.name, ",") AS roles'),
                ])
                ->leftJoin('user_has_roles', 'user_has_roles.user_id', '=', 'users.id')
                ->leftJoin('roles', 'roles.id', '=', 'user_has_roles.role_id')
                ->groupBy('users.id')
                ->orderBy('users.name')
                ->get(),
        );
    }
}

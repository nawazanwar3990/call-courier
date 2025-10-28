<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AbilityEnum;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleUserController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize(AbilityEnum::LIST, Role::class);

        $roleID = $request->query('role');
        $role = Role::findOrFail($roleID);

        $users = RoleUser::with([
            'user:id,email,username'
        ])
            ->where('role_id', $roleID)
            ->get();

        $params = [
            'pageTitle' => __('general.role_users') . ' - ' . $role->name,
            'breadCrumbs' => collect([
                __('general.dashboard') => route('admin.dashboard'),
                __('general.roles') => route('admin.roles.index'),
                __('general.role_users') => '',
            ]),
            'users' => $users
        ];

        return view('admin.role.users', $params);
    }
}

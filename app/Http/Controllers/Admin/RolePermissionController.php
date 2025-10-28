<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AbilityEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class RolePermissionController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize(AbilityEnum::LIST, Role::class);

        $roleID = $request->query('role');
        $role = Role::where('id', $roleID)
            ->where('label', '!=', RoleEnum::ROLE_SUPER_ADMIN)
            ->firstOrFail();
        $permissions = Permission::all();
        $params = [
            'pageTitle' => __('general.role_permissions') . ' - ' . $role->name,
            'breadCrumbs' => collect([
                __('general.dashboard') => route('admin.dashboard'),
                __('general.roles') => route('admin.roles.index'),
                __('general.role_permissions') => '',
            ]),
            'role_id' => $roleID,
            'permissions' => $permissions,
            'rolePermissions' => PermissionRole::where('role_id', $role->id)
                ->select(['permission_id', 'role_id'])
                ->get(),
        ];

        return view('admin.role.permissions', $params);
    }

    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $roleID = $request->input('role');
            $role = Role::findOrFail($roleID);
            $permissions = $request->input('permissions', []);
            if (count($permissions) > 0) {
                $role->permissions()->sync($permissions);
            }
            DB::commit();
            return response()->json(['success' => true, 'msg' => __('general.record_updated_msg')]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json(['success' => false, 'msg' => __('general.something_went_wrong')]);
        }
    }
}

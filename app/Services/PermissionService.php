<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\PermissionRole;

class PermissionService
{

    public static function getPermissionByName($name)
    {
        return Permission::where('name', $name)->value('id');
    }

    public static function hasAlreadyPermissionByName($name): bool
    {
        return Permission::where('name', $name)->exists();
    }

    public static function alreadyAssign($role_id, $permission_id): bool
    {
        return PermissionRole::where('role_id', $role_id)
            ->where('permission_id', $permission_id)
            ->exists();
    }

}

<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class RoleService
{

    public static function getRolesForDropdown(): Collection
    {
        return Role::query()
            ->where('label', '!=', RoleEnum::ROLE_SUPER_ADMIN)
            ->pluck('name', 'id');
    }

    public static function getRoleIdByName($name)
    {
        $record = Role::where('name', $name)->first();
        return $record?->id;
    }

    public static function getCurrentRole()
    {
        return Auth::user()->roles()[0];
    }

    public static function getCurrentRoleName(): string
    {
        return ucwords(str_replace('-', ' ', self::getCurrentRole()->name)) ?? '';
    }

    public static function getCurrentRoleSlug(): string
    {
        return self::getCurrentRole()->slug ?? '';
    }

    public static function getCurrentRoleId(): string
    {
        return self::getCurrentRole()->id ?? '';
    }

    public function findRoleById($roleId)
    {
        return Role::findOrFail($roleId);
    }
}

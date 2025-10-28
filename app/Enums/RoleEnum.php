<?php

declare(strict_types=1);

namespace App\Enums;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleEnum extends AbstractEnum
{
    public const ROLE_SUPER_ADMIN = 'super-admin';
    public const ROLE_USER = 'user';

    public static function getValues(): array
    {
        return [
            self::ROLE_SUPER_ADMIN,
            self::ROLE_USER
        ];
    }

    public static function getTranslationKeys(): array
    {
        return [
            self::ROLE_SUPER_ADMIN => Str::title(self::ROLE_SUPER_ADMIN),
            self::ROLE_USER => Str::title(self::ROLE_USER)
        ];
    }
    public static function checkPermission(Authenticatable $user, string $permission): bool
    {
        $permissions = self::getQuery($user);
        return $permissions->where('permissions.name', $permission)
            ->exists();
    }

    public static function getRolePermissionArray(): array
    {
        return self::getQuery(Auth::user())->pluck('permissions.name')->toArray();
    }

    public static function getQuery(Authenticatable $user): Builder
    {
        return DB::table(TableEnum::PERMISSIONS)
            ->join(TableEnum::PERMISSION_ROLE, 'permission_role.permission_id', 'permissions.id')
            ->join(TableEnum::ROLES, 'permission_role.role_id', 'roles.id')
            ->join(TableEnum::ROLE_USER, 'role_user.role_id', 'roles.id')
            ->join(TableEnum::USERS, 'role_user.user_id', 'users.id')
            ->where('roles.id', $user->getRoleId())
            ->where('users.id', $user->id);
    }
}

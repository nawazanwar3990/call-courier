<?php

declare(strict_types=1);

namespace App\Enums;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Services\PermissionService;
use App\Services\RoleService;

class PermissionEnum extends AbstractEnum
{
    public static function getValues(): array
    {
        return [
        ];
    }

    public static function getTranslationKeys(): array
    {
        return [

        ];
    }

    public static function allGenericPermissions(): array
    {
        return [
            KeywordEnum::USER,
            KeywordEnum::ROLE,
            KeywordEnum::PERMISSION,
            KeywordEnum::BRANCH,
            KeywordEnum::PASSWORD_RESET
        ];
    }

    public static function defaultSuperAdminPermission(): array
    {
        $permissions = [
            'view_dashboard',
            'view_profile',
        ];
        foreach (self::allGenericPermissions() as $permission) {
            foreach (AbilityEnum::getValues() as $ability) {
                $permissions[] = $ability . "_" . $permission;
            }
        }
        return $permissions;
    }

    public static function defaultUserPermissions(): array
    {
        return [
            'view_dashboard',
            'view_profile'
        ];
    }

    public static function syncPermission(): void
    {
        self::savePermissions();
        self::syncRolePermissions(RoleEnum::ROLE_SUPER_ADMIN);
        self::syncRolePermissions(RoleEnum::ROLE_USER);
    }

    public static function syncRolePermissions($role): void
    {
        $roleId = RoleService::getRoleIdByName($role);
        $permissions = match ($role) {
            RoleEnum::ROLE_SUPER_ADMIN => self::defaultSuperAdminPermission(),
            RoleEnum::ROLE_USER => self::defaultUserPermissions(),
            default => array(),
        };
        if (count($permissions) > 0) {
            foreach ($permissions as $permission) {
                if (PermissionService::hasAlreadyPermissionByName($permission)) {
                    self::applySyncing(PermissionService::getPermissionByName($permission), $roleId);
                }
            }
        }
    }

    public static function savePermissions(): void
    {
        foreach (self::allGenericPermissions() as $permission) {
            foreach (AbilityEnum::getValues() as $ability) {
                $name = $ability . "_" . $permission;
                Permission::updateOrCreate([
                    'name' => $name
                ], [
                    'label' => ucwords(str_replace('_', ' ', $name)),
                    'created_by' => 1,
                    'updated_by' => 1
                ]);
            }
        }

    }

    private static function applySyncing($pId, $roleId): void
    {
        PermissionRole::updateOrCreate([
            'permission_id' => $pId,
            'role_id' => $roleId
        ], [
            'permission_id' => $pId,
            'role_id' => $roleId
        ]);
    }
}

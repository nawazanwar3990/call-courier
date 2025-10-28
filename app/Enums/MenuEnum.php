<?php

namespace App\Enums;
class MenuEnum extends AbstractEnum
{
    public const DASHBOARD = KeywordEnum::DASHBOARD;
    public const USER = KeywordEnum::USER;
    public const ROLE = KeywordEnum::ROLE;
    public const PERMISSION = KeywordEnum::PERMISSION;
    public const BRANCH = KeywordEnum::BRANCH;

    public const PASSWORD_RESET = KeywordEnum::PASSWORD_RESET;

    public static function getValues(): array
    {
        return [
            self::DASHBOARD,
            self::USER,
            self::ROLE,
            self::PERMISSION,
            self::BRANCH,
            self::PASSWORD_RESET
        ];
    }

    public static function getTranslationKeys(): array
    {
        return [
            self::DASHBOARD => __('general.' . self::DASHBOARD),
            self::USER => __('general.users'),
            self::BRANCH => __('general.branches'),
            self::PASSWORD_RESET => __('general.password_resets')
        ];
    }

    public static function getPermissionName($key = null): ?string
    {
        return AbilityEnum::VIEW . "_" . $key;
    }

    public static function getIcon($key = null): ?string
    {
        $icons = [
            self::DASHBOARD => '<i class="menu-icon fas fa-tachometer-alt"></i>',
            self::USER => '<i class="menu-icon fas fa-user"></i>',
            self::ROLE => '<i class="menu-icon fas fa-user-shield"></i>',
            self::PERMISSION => '<i class="menu-icon fas fa-key"></i>',
            self::BRANCH => '<i class="menu-icon fas fa-tasks"></i>',
            self::PASSWORD_RESET => '<i class="menu-icon fas fa-eye"></i>',
        ];

        return $icons[$key] ?? null;
    }

    public static function getRoute($key = null): ?string
    {
        $icons = [
            self::DASHBOARD => route('admin.dashboard'),
            self::USER => route('admin.users.index'),
            self::ROLE => route('admin.roles.index'),
            self::PERMISSION => route('admin.permissions.index'),
            self::BRANCH => route('admin.branches.index'),
            self::PASSWORD_RESET => route('admin.password.resets',['status'=>PasswordResetStatusEnum::REQUESTED])
        ];
        return $icons[$key] ?? null;
    }
}

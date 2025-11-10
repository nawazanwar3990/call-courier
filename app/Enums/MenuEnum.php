<?php

namespace App\Enums;
class MenuEnum extends AbstractEnum
{
    public const DASHBOARD = KeywordEnum::DASHBOARD;
    public const USER = KeywordEnum::USER;
    public const BRANCH = KeywordEnum::BRANCH;

    public static function getValues(): array
    {
        return [
            self::DASHBOARD,
            self::USER,
            self::BRANCH
        ];
    }

    public static function getTranslationKeys(): array
    {
        return [
            self::DASHBOARD => __('general.' . self::DASHBOARD),
            self::USER => __('general.users'),
            self::BRANCH => __('general.branches')
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
            self::BRANCH => '<i class="menu-icon fas fa-tasks"></i>'
        ];

        return $icons[$key] ?? null;
    }

    public static function getRoute($key = null): ?string
    {
        $icons = [
            self::DASHBOARD => route('admin.dashboard'),
            self::USER => route('admin.users.index'),
            self::BRANCH => route('admin.branches.index')
        ];
        return $icons[$key] ?? null;
    }
}

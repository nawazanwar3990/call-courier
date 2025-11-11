<?php

namespace App\Enums;
class MenuEnum extends AbstractEnum
{
    public const SCANNED_DATA = 'scanned_data';
    public const USER = KeywordEnum::USER;
    public const BRANCH = KeywordEnum::BRANCH;

    public static function getValues(): array
    {
        return [
            self::USER,
            self::BRANCH
        ];
    }

    public static function getTranslationKeys(): array
    {
        return [
            self::SCANNED_DATA => 'Scanned Data',
            self::USER =>'Users',
            self::BRANCH =>'Branches'
        ];
    }

    public static function getPermissionName($key = null): ?string
    {
        return AbilityEnum::VIEW . "_" . $key;
    }

    public static function getIcon($key = null): ?string
    {
        $icons = [
            self::SCANNED_DATA => '<i class="menu-icon fas fa-scanner-image"></i>',
            self::USER => '<i class="menu-icon fas fa-user"></i>',
            self::BRANCH => '<i class="menu-icon fas fa-tasks"></i>'
        ];

        return $icons[$key] ?? null;
    }

    public static function getRoute($key = null): ?string
    {
        $icons = [
            self::USER => route('admin.users.index'),
            self::BRANCH => route('admin.branches.index'),
            self::SCANNED_DATA => route('admin.data.index'),
        ];
        return $icons[$key] ?? null;
    }
}

<?php

namespace App\Enums;
class MenuEnum extends AbstractEnum
{
    public const DASHBOARD = KeywordEnum::DASHBOARD;
    public const USER = KeywordEnum::USER;
    public const ROLE = KeywordEnum::ROLE;
    public const PERMISSION = KeywordEnum::PERMISSION;
    public const TASK = KeywordEnum::TASK;

    public const TYPE = KeywordEnum::TYPE;
    public const GIFT_CARD = KeywordEnum::GIFT_CARD;

    public const INVENTORY = KeywordEnum::INVENTORY;
    public const SUBMISSIONS = KeywordEnum::SUBMISSION;

    public const REDEEMS = KeywordEnum::REDEEM;

    public const PASSWORD_RESET = KeywordEnum::PASSWORD_RESET;

    public static function getValues(): array
    {
        return [
            self::DASHBOARD,
            self::USER,
            self::ROLE,
            self::PERMISSION,
            self::TASK,
            self::TYPE,
            self::GIFT_CARD,
            self::INVENTORY,
            self::SUBMISSIONS,
            self::REDEEMS,
            self::PASSWORD_RESET
        ];
    }

    public static function getTranslationKeys(): array
    {
        return [
            self::DASHBOARD => __('general.' . self::DASHBOARD),
            self::USER => __('general.users'),
            self::TASK => __('general.branches'),
            self::TYPE => __('general.types'),
            self::GIFT_CARD => __('general.gift-cards'),
            self::INVENTORY => __('general.inventories'),
            self::SUBMISSIONS => __('general.submissions'),
            self::REDEEMS => __('general.redeems'),
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
            self::TASK => '<i class="menu-icon fas fa-tasks"></i>',
            self::TYPE => '<i class="menu-icon fas fa-tags"></i>',
            self::GIFT_CARD => '<i class="menu-icon fas fa-gift"></i>',
            self::INVENTORY => '<i class="menu-icon fas fa-boxes"></i>',
            self::SUBMISSIONS => '<i class="menu-icon fas fa-file-alt"></i>',
            self::REDEEMS => '<i class="menu-icon fas fa-coins"></i>',
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
            self::TASK => route('admin.branches.index'),
            self::TYPE => route('admin.types.index'),
            self::GIFT_CARD => route('admin.gift-cards.index'),
            self::INVENTORY => route('admin.inventories.index'),
            self::SUBMISSIONS => route('admin.submissions.index'),
            self::REDEEMS => route('admin.redeems.index',['status'=>RedeemStatusEnum::REQUESTED]),
            self::PASSWORD_RESET => route('admin.password.resets',['status'=>PasswordResetStatusEnum::REQUESTED])
        ];
        return $icons[$key] ?? null;
    }
}

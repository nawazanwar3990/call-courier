<?php

namespace App\Enums;

class KeywordEnum extends AbstractEnum
{
    public const DASHBOARD = 'dashboard';
    public const USER = 'user';
    public const ROLE = 'role';
    public const PERMISSION = 'permission';
    public const TASK = 'task';
    public const GIFT_CARD = 'gift_card';
    public const TYPE = 'type';
    public const SUBMISSION = 'submission';
    public const INVENTORY = 'inventory';
    public const REDEEM = 'redeem';
    public const PASSWORD_RESET = 'password_resets';

    public static function getValues(): array
    {
        return [];
    }

    public static function getTranslationKeys(): array
    {
        return [];
    }
}

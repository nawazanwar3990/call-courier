<?php

namespace App\Enums;

class KeywordEnum extends AbstractEnum
{
    public const DASHBOARD = 'dashboard';
    public const USER = 'user';
    public const ROLE = 'role';
    public const PERMISSION = 'permission';
    public const BRANCH = 'branch';
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

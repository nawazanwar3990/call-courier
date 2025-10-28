<?php

declare(strict_types=1);

namespace App\Enums;
class CacheEnum extends AbstractEnum
{
    public const CURRENT_USER_PERMISSION = 'current_user_permissions';
    public const LANG_JS = 'lang_js';

    public static function getValues(): array
    {
        return array(
            self::CURRENT_USER_PERMISSION
        );
    }

    public static function getTranslationKeys(): array
    {
        return array();
    }

    public static function getDayExpiryTime(int $day = 1): int
    {
        return (int)(60 * 60 * 24 * $day);
    }

    public static function getMonthExpiryTime(int $month = 1): int
    {
        return (int)(60 * 60 * 24 * 30 * $month);
    }

    public static function getHourExpiryTime(int $hour = 1): int
    {
        return (int)(60 * 60 * $hour);
    }
}

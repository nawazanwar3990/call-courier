<?php

declare(strict_types=1);

namespace App\Enums;

class NotificationPositionEnum extends AbstractEnum
{
    public const HEADER_LIST = 'header_list';
    public const ADMIN_LIST = 'admin_list';
    public const WEBSITE_LIST = 'website_list';
    public static function getValues(): array
    {
        return [
            self::HEADER_LIST,
            self::ADMIN_LIST,
            self::WEBSITE_LIST
        ];
    }
    public static function getTranslationKeys(): array
    {
        return [

        ];
    }
}

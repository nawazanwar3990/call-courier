<?php

declare(strict_types=1);

namespace App\Enums;
class EmailTypeEnum extends AbstractEnum
{
    public const PASSWORD_RESET_REQUESTED = 'password_reset_requested';
    public const PASSWORD_RESET_PROCESSED = 'password_reset_processed';

    public static function getValues(): array
    {
        return [
            self::PASSWORD_RESET_REQUESTED,
            self::PASSWORD_RESET_PROCESSED
        ];
    }
    public static function getTranslationKeys(): array
    {
        return [
            self::PASSWORD_RESET_REQUESTED => __('general.'.self::PASSWORD_RESET_REQUESTED),
            self::PASSWORD_RESET_PROCESSED => __('general.'.self::PASSWORD_RESET_PROCESSED)
        ];
    }
}

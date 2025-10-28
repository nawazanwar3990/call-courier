<?php

declare(strict_types=1);

namespace App\Enums;

class PasswordResetStatusEnum extends AbstractEnum
{
    public const REQUESTED = 'requested';
    public const PROCESSED = 'processed';

    public static function getValues(): array
    {
        return [
            self::REQUESTED,
            self::PROCESSED
        ];
    }

    public static function generateButton($key): string
    {
        $classes = [
            self::REQUESTED => 'btn btn-success  btn-md',
            self::PROCESSED => 'btn btn-warning btn-md'
        ];

        return sprintf(
            '<button class="%s">%s</button>',
            $classes[$key] ?? 'btn btn-light',
            __('general.' . $key)
        );
    }

    public static function getTranslationKeys(): array
    {
        return [
            self::REQUESTED => __('general.' . self::REQUESTED),
            self::PROCESSED => __('general.' . self::PROCESSED)
        ];
    }
}

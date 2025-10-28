<?php

declare(strict_types=1);

namespace App\Enums;

class RedeemStatusEnum extends AbstractEnum
{
    public const REQUESTED = 'requested';
    public const APPROVED = 'approved';


    public static function getValues(): array
    {
        return [
            self::REQUESTED,
            self::APPROVED
        ];
    }

    public static function generateButton($key): string
    {
        $classes = [
            self::REQUESTED => 'btn btn-info btn-md',
            self::APPROVED => 'btn btn-success btn-md',
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
            self::APPROVED => __('general.' . self::APPROVED)
        ];
    }
}

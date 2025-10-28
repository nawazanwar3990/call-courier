<?php

declare(strict_types=1);

namespace App\Enums;

class InventoryStatusEnum extends AbstractEnum
{
    public const AVAILABLE = 'available';
    public const USED = 'used';
    public const INACTIVE = 'inactive';

    public static function getValues(): array
    {
        return [
            self::AVAILABLE,
            self::USED,
            self::INACTIVE
        ];
    }

    public static function generateButton($key): string
    {
        $classes = [
            self::AVAILABLE => 'btn btn-success  btn-md',
            self::USED => 'btn btn-warning btn-md',
            self::INACTIVE => 'btn btn-secondary btn-md',
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
            self::AVAILABLE => __('general.' . self::AVAILABLE),
            self::USED => __('general.' . self::USED),
            self::INACTIVE => __('general.' . self::INACTIVE)
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Enums;
class AbilityEnum extends AbstractEnum
{
    public const LIST = 'list';
    public const VIEW = 'view';
    public const CREATE = 'create';
    public const UPDATE = 'update';
    public const DELETE = 'delete';
    public const ALL = 'all';

    public static function getValues(): array
    {
        return [
            self::LIST,
            self::VIEW,
            self::CREATE,
            self::UPDATE,
            self::DELETE
        ];
    }

    public static function getTranslationKeys(): array
    {
        return [
            //
        ];
    }
}

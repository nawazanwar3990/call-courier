<?php

declare(strict_types=1);

namespace App\Enums;
class SessionEnum extends AbstractEnum
{
    public const LANGUAGE = 'language';

    public static function getValues(): array
    {
        return [
            self::LANGUAGE
        ];
    }

    public static function getTranslationKeys(): array
    {
        return [
            //
        ];
    }
}

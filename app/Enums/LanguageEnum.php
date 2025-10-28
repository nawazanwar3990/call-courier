<?php

namespace App\Enums;

class LanguageEnum extends AbstractEnum
{
    Public Const ENGLISH = 'english';
    Public Const URDU = 'urdu';

    public static function getValues(): array
    {
        return [
            self::ENGLISH,
            self::URDU,
        ];
    }

    public static function getTranslationKeys(): array
    {
        return [
            self::ENGLISH => __(sprintf('%s.%s', 'general', self::ENGLISH)),
            self::URDU => __(sprintf('%s.%s', 'general', self::URDU)),
        ];
    }
}

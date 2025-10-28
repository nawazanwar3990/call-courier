<?php

declare(strict_types=1);

namespace App\Enums;

interface EnumInterface
{
    /**
     * @param mixed $enum
     */
    public static function isValid($enum): bool;

    /**
     * @param mixed $enum
     */
    public static function getKey($enum): string;

    public static function getValues(): array;
}

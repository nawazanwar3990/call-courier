<?php

declare(strict_types=1);

namespace App\Enums;

class SubmissionStatusEnum extends AbstractEnum
{
    public const SUBMITTED = 'submitted';

    public const RE_SUBMIT = 're_submit';
    public const APPROVED = 'approved';
    public const REJECTED = 'rejected';
    public static function getValues(): array
    {
        return [
            self::SUBMITTED,
            self::RE_SUBMIT,
            self::APPROVED,
            self::REJECTED
        ];
    }

    public static function generateButton($key): string
    {
        $classes = [
            self::SUBMITTED => 'btn btn-info  btn-md',
            self::RE_SUBMIT => 'btn btn-warning btn-md',
            self::APPROVED => 'btn btn-success btn-md',
            self::REJECTED => 'btn btn-danger btn-md',
        ];

        return sprintf(
            '<button class="%s">%s</button>',
            $classes[$key] ?? 'btn btn-light',
            __('general.' . $key)
        );
    }

    public static function AdminSubmissionStatus(): array
    {
        return [
            self::APPROVED,
            self::REJECTED
        ];
    }

    public static function getTranslationKeys(): array
    {
        return [
            self::SUBMITTED => __('general.' . self::SUBMITTED),
            self::RE_SUBMIT => __('general.' . self::RE_SUBMIT),
            self::APPROVED => __('general.' . self::APPROVED),
            self::REJECTED => __('general.' . self::REJECTED)
        ];
    }
}

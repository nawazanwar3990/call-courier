<?php

namespace App\Enums;

class TableEnum extends AbstractEnum
{
    public const ACTIVITY_LOG = 'activity_log';
    public const CACHE = 'cache';
    public const CACHE_LOCKS = 'cache_locks';
    public const SESSIONS = 'sessions';
    public const USERS = 'users';
    public const PASSWORD_RESET_TOKENS = 'password_reset_tokens';
    public const JOBS = 'jobs';
    public const JOB_BATCHES = 'job_batches';
    public const FAILED_JOBS = 'failed_jobs';
    public const ROLES = 'roles';
    public const PERMISSIONS = 'permissions';
    public const ROLE_USER = 'role_user';
    public const PERMISSION_ROLE = 'permission_role';
    public const MEDIA = 'media';
    public const NOTIFICATIONS = 'notifications';
    public const BRANCHES = 'branches';
    public const GIFT_CARDS = 'gift_cards';

    public const SUBMISSIONS = 'submissions';
    public const TYPES = 'types';
    public const INVENTORIES = 'inventories';
    public const REDEEMS = 'redeems';
    public const HISTORIES = 'histories';
    public const PASSWORD_RESETS = 'password_resets';

    public static function getValues(): array
    {
        return [
            //
        ];
    }

    public static function getTranslationKeys(): array
    {
        return [
            //
        ];
    }
}

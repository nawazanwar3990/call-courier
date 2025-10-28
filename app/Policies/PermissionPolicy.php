<?php

namespace App\Policies;

use App\Enums\KeywordEnum;

class PermissionPolicy extends AbstractDefaultPolicy
{
    protected const KEYWORD = KeywordEnum::PERMISSION;
}

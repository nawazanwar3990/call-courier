<?php

namespace App\Policies;

use App\Enums\KeywordEnum;

class RolePolicy extends AbstractDefaultPolicy
{
    protected const KEYWORD = KeywordEnum::ROLE;
}

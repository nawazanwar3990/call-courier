<?php

namespace App\Policies;

use App\Enums\KeywordEnum;

class UserPolicy extends AbstractDefaultPolicy
{
    protected const KEYWORD = KeywordEnum::USER;
}

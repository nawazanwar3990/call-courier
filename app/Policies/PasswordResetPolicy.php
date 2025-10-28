<?php

namespace App\Policies;

use App\Enums\KeywordEnum;
use App\Policies\AbstractDefaultPolicy;

class PasswordResetPolicy extends AbstractDefaultPolicy
{
    protected const KEYWORD = KeywordEnum::PASSWORD_RESET;
}

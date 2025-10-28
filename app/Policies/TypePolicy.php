<?php

namespace App\Policies;

use App\Enums\KeywordEnum;
use App\Policies\AbstractDefaultPolicy;

class TypePolicy extends AbstractDefaultPolicy
{
    protected const KEYWORD = KeywordEnum::TYPE;
}

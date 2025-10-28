<?php

namespace App\Policies;

use App\Enums\KeywordEnum;
use App\Policies\AbstractDefaultPolicy;

class BranchPolicy extends AbstractDefaultPolicy
{
    protected const KEYWORD = KeywordEnum::BRANCH;
}

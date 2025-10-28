<?php

namespace App\Policies;

use App\Enums\KeywordEnum;
use App\Policies\AbstractDefaultPolicy;

class TaskPolicy extends AbstractDefaultPolicy
{
    protected const KEYWORD = KeywordEnum::TASK;
}

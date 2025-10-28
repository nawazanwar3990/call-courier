<?php

namespace App\Policies;

use App\Enums\KeywordEnum;
use App\Policies\AbstractDefaultPolicy;

class SubmissionPolicy extends AbstractDefaultPolicy
{
    protected const KEYWORD = KeywordEnum::SUBMISSION;
}

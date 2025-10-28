<?php

namespace App\Policies;

use App\Enums\KeywordEnum;
use App\Policies\AbstractDefaultPolicy;

class RedeemPolicy extends AbstractDefaultPolicy
{
    protected const KEYWORD = KeywordEnum::REDEEM;
}

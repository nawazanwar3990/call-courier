<?php

namespace App\Policies;

use App\Enums\KeywordEnum;
use App\Policies\AbstractDefaultPolicy;

class GiftCardPolicy extends AbstractDefaultPolicy
{
    protected const KEYWORD = KeywordEnum::GIFT_CARD;
}

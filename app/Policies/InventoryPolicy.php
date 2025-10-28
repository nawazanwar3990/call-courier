<?php

namespace App\Policies;

use App\Enums\KeywordEnum;
use App\Policies\AbstractDefaultPolicy;

class InventoryPolicy extends AbstractDefaultPolicy
{
    protected const KEYWORD = KeywordEnum::INVENTORY;
}

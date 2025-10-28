<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\AbilityEnum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class AbstractDefaultPolicy
{
    use HandlesAuthorization;

    protected const KEYWORD = null;

    public function list(User $user): bool
    {
        return $user->ability(sprintf('%s_%s',AbilityEnum::LIST,static::KEYWORD));
    }

    public function view(User $user): bool
    {
        return $user->ability(sprintf('%s_%s',AbilityEnum::VIEW,static::KEYWORD));
    }

    public function create(User $user): bool
    {
        return $user->ability(sprintf('%s_%s',AbilityEnum::CREATE,static::KEYWORD));
    }

    public function update(User $user): bool
    {
        return $user->ability(sprintf('%s_%s',AbilityEnum::UPDATE,static::KEYWORD));
    }

    public function delete(User $user): bool
    {
        return $user->ability(sprintf('%s_%s',AbilityEnum::DELETE,static::KEYWORD));
    }
}

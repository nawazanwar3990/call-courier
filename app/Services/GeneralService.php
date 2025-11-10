<?php

namespace App\Services;
use App\Models\Branch;
use Illuminate\Support\Collection;

class GeneralService
{
    public static function pluckBranches()
    {
        return Branch::withoutTrashed()
            ->active()
            ->orderBy('id', 'DESC')
            ->pluck('name','id');
    }
}

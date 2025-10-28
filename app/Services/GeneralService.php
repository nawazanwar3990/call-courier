<?php

namespace App\Services;

use App\Models\GiftCard;
use App\Models\Branch;
use App\Models\Type;
use Illuminate\Support\Collection;

class GeneralService
{

    public static function getTypeDropdown(): Collection
    {
        return Type::active()->pluck('name', 'id');
    }

    public static function getGiftCardDropdown(): Collection
    {
        return GiftCard::active()->pluck('name', 'id');
    }

    public static function generateRandomString(int $length = 20, bool $useLetters = true, bool $useNumbers = true): string
    {
        return (new Collection)
            ->when($useLetters, fn($c) => $c->merge([
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
                'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            ]))
            ->when($useNumbers, fn($c) => $c->merge([
                '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            ]))
            ->pipe(fn($c) => Collection::times($length, fn() => $c[random_int(0, $c->count() - 1)]))
            ->implode('');
    }

    public static function getDaily()
    {

    }

    public static function getGiftCards($limit = 10)
    {
        return GiftCard::withoutTrashed()
            ->with('type')
            ->active()
            ->latest()
            ->limit($limit)
            ->get();
    }

    public static function allTasks()
    {
        return Branch::withoutTrashed()
            ->with(['submissions', 'userSubmissions'])
            ->withCount('submissions')
            ->active()
            ->orderBy('id', 'DESC')
            ->get();
    }
}

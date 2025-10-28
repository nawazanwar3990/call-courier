<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public static function getUsersForDropdown(): Collection
    {
        return User::select(['id', 'username'])
            ->get()
            ->pluck('username', 'id');
    }

    public static function hasRole($role): bool
    {
        $currentRole = strtolower(Auth::user()->roles[0]->name);
        return $role == $currentRole;
    }
    public static function hasRoleByUser($user,$role): bool
    {
        $currentRole = strtolower($user->roles[0]->name);
        return $role == $currentRole;
    }
    public static function findByRoleName(string $role): ?User
    {
        return User::whereHas('roles', function ($query) use ($role) {
            $query->where('name', strtolower($role));
        })->first();
    }
}

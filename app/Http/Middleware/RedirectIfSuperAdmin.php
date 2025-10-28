<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $role = strtolower($user->roles[0]->name);
        if ($user && $role === RoleEnum::ROLE_SUPER_ADMIN) {
            return redirect()->route('admin.users.index');
        }
        return $next($request);
    }
}

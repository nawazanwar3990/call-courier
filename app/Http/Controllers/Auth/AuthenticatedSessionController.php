<?php

namespace App\Http\Controllers\Auth;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        $params = [
            "pageTitle" => trans('sm.login'),
            "pageDescription" =>trans('sm.login'),
            "pageKeywords" => trans('sm.login')
        ];
        return view('auth.login', $params);
    }
    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ], [
            'login.required' => 'Please enter your email, username, or mobile number to log in.',
            'password.required' => 'Please enter your password.',
            'remember.boolean' => 'Invalid value for remember me.',
        ]);

        // Try to find user by email, mobile, or username
        $user = User::where('username', $request->login)
            ->first();

        // Validate credentials manually
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'The provided credentials do not match our records.',
            ]);
        }
        $remember = $request->boolean('remember');
        Auth::login($user, $remember);
        $user->load(['roles']);
        $role = strtolower($user->roles->first()->name ?? '');

        return redirect()->intended(route('admin.dashboard'));
    }
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        Cache::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

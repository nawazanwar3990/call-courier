<?php

namespace App\Http\Controllers\Auth;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\Request;
class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $params = [
            "pageTitle" => trans('sm.register'),
            "pageDescription" => trans('sm.register'),
            "pageKeywords" => trans('sm.register')
        ];
        return view('auth.register', $params);
    }
    public function store(Request $request)
    {
        // Validate user input with custom messages
        $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'privacy_policy' => 'required|accepted',
        ], [
            'username.required' => 'Username is required.',
            'username.unique' => 'This username is already taken.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'privacy_policy.required' => 'You must agree to the Privacy Policy.',
            'privacy_policy.accepted' => 'Please accept the Privacy Policy.',
        ]);
        $privacy_policy = $request->boolean('privacy_policy');
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        // Create user
        $user = User::create([
            'username' => $username,
            'email' => $email,
            'privacy_policy' => $privacy_policy,
            'password' =>Hash::make($password)
        ]);

        // Assign default role
        $roleId = RoleService::getRoleIdByName(RoleEnum::ROLE_USER);
        $user->roles()->attach([$roleId]);
        // Log the user in
        Auth::login($user);
        // Redirect with success message
        return redirect()->route('admin.dashboard')->with('success', 'Registration successful! Welcome to our platform.');
    }
}

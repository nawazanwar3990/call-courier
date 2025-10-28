<?php

namespace App\Http\Controllers\Auth;
use App\Enum\MailEnum;
use App\Enum\TableEnum;
use App\Http\Controllers\Controller;
use App\Mail\GlobalMail;
use App\Models\PasswordReset;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm(): Factory|View|Application
    {
        $pageTitle = 'Forgot Password!';
        $pageKeywords='Reset Password,Change Password';
        $pageDescription = 'Forgot your password? No problem. Just let us know your email address, and we will email you
                    a password reset link that will allow you to choose a new one.';
        return view('auth.forget-password', compact('pageTitle', 'pageDescription','pageKeywords'));
    }

    public function submitForgetPasswordForm(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);
        $email = $request->input('email', null);
        $token = Str::random(64);
        $model = PasswordReset::updateOrCreate([
            'email' => $email
        ],[
            'token' => $token
        ]);
        try {
            Mail::to($email)->send(new GlobalMail(
                MailEnum::PASSWORD_RESET,
                MailEnum::getTranslationKeyBy(MailEnum::PASSWORD_RESET),
                $model
            ));
            return response()->json([
                'success' => true,
                'msg' => __('sm.reset_password_mail_success_msg')
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => __('sm.something_went_wrong')]);
        }
    }

    public function showResetPasswordForm($token): Factory|View|Application
    {
        $model = PasswordReset::whereToken($token)->first();
        $pageTitle = 'Rest Password';
        $pageDescription = 'Please fill your Information for Resetting Password';
        $pageKeywords='Updated Password,Change Password';
        return view('auth.forget-password-Link',compact(
            'token',
            'pageTitle',
            'pageDescription',
            'pageKeywords',
            'model'
        ));
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        $email = $request->input('email', null);
        $token = $request->input('token', null);
        $password = $request->input('password', null);
        $updatePassword = DB::table(TableEnum::PASSWORD_RESETS)
            ->where([
                'email' => $email,
                'token' => $token
            ])->first();
        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }
        User::where('email', $email)
            ->update([
                'password' => Hash::make($password)
            ]);
        DB::table(TableEnum::PASSWORD_RESETS)->where([
            'email' => $email
        ])->delete();

        return response()->json([
            'success' => true,
            'msg' => __('sm.password_change_success_msg'),
            'redirect' => route('login')
        ]);
    }
}

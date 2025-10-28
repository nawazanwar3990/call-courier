<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EmailTypeEnum;
use App\Enums\PasswordResetStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetListRequest;
use App\Mail\GlobalMail;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Gate;
use App\Enums\AbilityEnum;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\json;

class PasswordResetController extends Controller
{
    public function index(PasswordResetListRequest $request)
    {
        Gate::authorize(AbilityEnum::LIST, PasswordReset::class);
        $status = $request->query('status');
        if ($request->ajax()) {
            return $request->processRequest();
        }
        $params = [
            'pageTitle' => __('general.password_resets'),
            'breadCrumbs' => collect([
                __('general.dashboard') => route('admin.dashboard'),
                __('general.password_resets') => '',
            ]),
            'status' => $status
        ];

        return view('admin.password-resets.index', $params);
    }

    public function change(Request $request, $id)
    {
        $model = PasswordReset::find($id);
        $params = [
            'pageTitle' => __('general.change_password'),
            'breadCrumbs' => collect([
                __('general.dashboard') => route('admin.dashboard'),
                __('general.password_resets') => '',
            ]),
            'model' => $model
        ];
        return view('admin.password-resets.change', $params);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|min:8|confirmed',
        ]);

        $modal = PasswordReset::with('createdBy')->find($id);
        $modal->status = PasswordResetStatusEnum::PROCESSED;
        $modal->updated_by = $request->input('updated_by');
        $modal->save();

        $new_password = $request->input('new_password');

        $user = $modal->createdBy;
        $user->password = Hash::make($new_password);
        $user->save();

        $user->new_password = $new_password;
        Mail::to($modal->createdBy->email)->send(new GlobalMail(
            EmailTypeEnum::PASSWORD_RESET_PROCESSED,
            EmailTypeEnum::getTranslationKeyBy(EmailTypeEnum::PASSWORD_RESET_PROCESSED),
            $user
        ));
        return [
            'success' => true,
            'msg' => 'Password changed successfully',
            'redirect_url' => route('admin.password.resets', ['status' => PasswordResetStatusEnum::PROCESSED])
        ];
    }
}

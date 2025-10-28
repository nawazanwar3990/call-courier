<?php

namespace App\Http\Requests;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'type' => ['required', 'string', Rule::in(['profile', 'password', 'two-factor'])],
        ];

        if ($this->type === 'profile') {
            return array_merge($rules, [
                'profile_picture' => ['file', 'mimes:png,jpg,jpeg', 'max:2048'],
            ]);
        }
        elseif ($this->type === 'password') {
            return array_merge($rules, [
                'old_password' => ['required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail(__('general.old_password_do_not_match'));
                    }
                },],

                'new_password' => ['required', 'confirmed', 'different:old_password', Password::default()],
            ]);
        }
        else {
            return array_merge($rules, [
                'enable' => ['boolean'],
                'verification_code' => ['sometimes', 'required', 'string', 'min:8', 'max:8'],
            ]);
        }
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $genericMerge = [];
        if (! empty($genericMerge)) {
            $this->merge($genericMerge);
        }
    }

    public function saveRecord(): array
    {
        DB::beginTransaction();
        try {

            $returnValue = ['success' => false, 'msg' => __('general.something_went_wrong')];

            if ($this->validated('type') === 'profile') {
                $returnValue = $this->updateProfile();
            }
            elseif ($this->validated('type') === 'password') {
                $returnValue = $this->updatePassword();
            }
            DB::commit();
            return $returnValue;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return ['success' => false, 'msg' => __('general.something_went_wrong')];
        }
    }

    private function updateProfile(): array
    {
        $user = User::query()->findOrFail(auth()->id());
        $user->privacy_policy = $this->boolean('privacy_policy');
        $user->save();
        if ($this->hasFile('profile_picture')) {
            $user->addMediaFromRequest('profile_picture')
                ->usingName('picture')
                ->toMediaCollection('picture');
        }
        return ['success' => true, 'msg' => __('general.profile_updated_msg')];
    }

    private function updatePassword(): array
    {
        $user = User::query()->findOrFail(auth()->id());
        $user->password = Hash::make($this->validated('new_password'));
        $user->save();

        return ['success' => true, 'msg' => __('general.password_changed_msg')];
    }
}

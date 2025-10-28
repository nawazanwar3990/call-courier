<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $mergeData = ['active' => $this->boolean('active')];

        $this->merge(array_merge($mergeData, [
            $this->missing('model_id') ? 'created_by' : 'updated_by' => auth()->id(),
        ]));
    }

    public function rules(): array
    {
        if ($this->isMethod('delete')) {
            return [];
        }

        $modelId = $this->route('model_id') ?? $this->input('model_id');

        return [
            'picture'     => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
            'active'      => ['boolean'],
            'username'    => ['required', Rule::unique('users', 'username')->ignore($modelId)],
            'email'       => ['nullable', 'email', Rule::unique('users', 'email')->ignore($modelId)],
            'mobile'      => ['required',Rule::unique('users', 'mobile')->ignore($modelId)],
            'password'    => [$this->isMethod('post') ? 'required' : 'nullable'],
            'created_by'  => ['nullable', 'exists:users,id'],
            'updated_by'  => ['nullable', 'exists:users,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function saveRecord(): array
    {
        DB::beginTransaction();

        try {
            $data = collect($this->validated())
                ->except('password', 'picture', 'role')
                ->toArray();

            $data['password'] = Hash::make($this->input('password', 'password'));

            $user = User::create($data);

            $roleId = RoleService::getRoleIdByName(RoleEnum::ROLE_USER);
            $user->roles()->sync($roleId);

            if ($this->hasFile('picture')) {
                $this->savePhoto($user);
            }

            DB::commit();

            return ['success' => true, 'msg' => __('general.record_added_msg')];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return ['success' => false, 'msg' => __('general.something_went_wrong')];
        }
    }

    public function updateRecord($id): array
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            $data = collect($this->validated())
                ->except('password', 'picture', 'model_id')
                ->toArray();

            if ($this->filled('password')) {
                $data['password'] = Hash::make($this->input('password'));
            }

            $user->update($data);

            if ($this->hasFile('picture')) {
                $this->savePhoto($user);
            }

            DB::commit();

            return ['success' => true, 'msg' => __('general.record_updated_msg')];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return ['success' => false, 'msg' => __('general.something_went_wrong')];
        }
    }

    public function deleteRecord($id): array
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();

            return ['success' => true, 'msg' => __('general.record_deleted_msg')];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return ['success' => false, 'msg' => __('general.something_went_wrong')];
        }
    }

    private function savePhoto(User $user): void
    {
        $user->addMediaFromRequest('picture')->toMediaCollection('picture');
    }
}

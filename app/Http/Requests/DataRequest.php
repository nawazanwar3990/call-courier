<?php

namespace App\Http\Requests;
use App\Models\Data;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->check() ? auth()->id() : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'cn_no' => ['required', 'array'],
            'cn_no.*' => ['required', 'string', 'max:255'],
            'user_id' => ['nullable', 'exists:users,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function saveRecords(): array
    {
        $validated = $this->validated();

        DB::beginTransaction();
        try {
            $records = [];
            foreach ($validated['cn_no'] as $cr) {
                $records[] = [
                    'cn_no' => $cr,
                    'user_id' => $validated['user_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Data::insert($records); // Bulk insert
            DB::commit();

            return ['success' => true, 'msg' => __('general.record_added_msg')];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return ['success' => false, 'msg' => __('general.something_went_wrong')];
        }
    }
}

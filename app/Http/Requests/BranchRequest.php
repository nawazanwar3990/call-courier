<?php

namespace App\Http\Requests;
use App\Models\Branch;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BranchRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $genericMerge = [
            'active' => $this->boolean('active'),
        ];

        if ($this->missing('model_id')) {
            $this->merge(array_merge($genericMerge, [
                'created_by' => auth()->check() ? auth()->id() : null,
            ]));
        } else {
            $this->merge(array_merge($genericMerge, [
                'updated_by' => auth()->check() ? auth()->id() : null,
            ]));
        }
    }

    public function rules(): array
    {
        if ($this->isMethod('delete')) {
            return [];
        }
        return [
            'task_name' => ['required', 'string', 'min:2', 'max:255'],
            'task_instruction' => ['required'],
            'task_url' => ['required'],
            'set_coins' => ['required'],
            'task_limit' => ['required'],
            'active' => ['boolean'],
            'picture' => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
            'created_by' => ['nullable', 'exists:users,id'],
            'updated_by' => ['nullable', 'exists:users,id']
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
                ->except('picture')
                ->toArray();
            $task = Branch::create($data);
            $this->savePhoto($task);
            DB::commit();
            return ['success' => true, 'msg' => __('general.record_added_msg')];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return ['success' => false, 'msg' => __('general.something_went_wrong')];
        }
    }

    public function updateRecord(): array
    {
        DB::beginTransaction();
        try {
            $modalId = $this->input('model_id');
            $data = collect($this->validated())
                ->except('picture')
                ->toArray();
            Branch::where('id',$modalId)->update($data);
            $task = Branch::findOrFail($modalId);
            $this->savePhoto($task);
            DB::commit();
            return ['success' => true, 'msg' => __('general.record_updated_msg')];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return ['success' => false, 'msg' => __('general.something_went_wrong')];
        }
    }

    private function savePhoto(Branch $task): void
    {
        if ($this->hasFile('picture')) {
            $task->addMediaFromRequest('picture')
                ->toMediaCollection('picture');
        }
    }
    public function deleteRecord($id): array
    {
        DB::beginTransaction();
        try {
            $modal = Branch::findOrFail($id);
            $modal->delete();
            DB::commit();
            return ['success' => true, 'msg' => __('general.record_deleted_msg')];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return ['success' => false, 'msg' => __('general.something_went_wrong')];
        }
    }
}

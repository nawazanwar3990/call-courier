<?php

namespace App\Http\Requests;

use App\Enums\SubmissionStatusEnum;
use App\Enums\TableEnum;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SubmissionListRequest extends FormRequest
{
    public function rules(): array
    {
        return [

        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function processRequest(): JsonResponse
    {
        $tableName = TableEnum::SUBMISSIONS;

        $records = Submission::whereNull('submissions.deleted_at')
            ->whereHas('createdBy', function ($query) {
                $query->whereNull('users.deleted_at');
            })
            ->whereHas('task', function ($query) {
                $query->whereNull('tasks.deleted_at');
            })->with(['createdBy', 'updatedBy', 'task']);

        $draw = $this->get('draw');
        $start = $this->get("start");
        $rowPerPage = $this->get("length");
        $columnOrderArr = collect($this->get('order'));
        $columnsArr = collect($this->get('columns'));

        $columnOrderArr->each(function ($item, $key) use ($columnsArr, &$isRowIdOrder) {
            if ($columnsArr[$item['column']]['data'] == 'DT_RowId') {
                $isRowIdOrder = true;
            }
        });

        $searchValue = $this->get('search')['value'];

        $totalRecords = $records->select("count({$tableName}.*) as allcount")->count();

        $records = $records
            ->leftJoin('tasks', "{$tableName}.task_id", '=', 'tasks.id')
            ->leftJoin('users as creator', "{$tableName}.created_by", '=', 'creator.id')
            ->leftJoin('users as updater', "{$tableName}.updated_by", '=', 'updater.id')
            ->when(strlen($searchValue), function (Builder $query) use ($searchValue, $tableName) {
                $query->where(function (Builder $q) use ($searchValue, $tableName) {
                    $q->where("{$tableName}.name", 'like', "%{$searchValue}%")
                        ->orWhere("{$tableName}.description", 'like', "%{$searchValue}%")
                        ->orWhere("{$tableName}.status", 'like', "%{$searchValue}%")
                        ->orWhere("{$tableName}.task_id", 'like', "%{$searchValue}%")
                        ->orWhere("tasks.name", 'like', "%{$searchValue}%");
                });
            })->select("{$tableName}.*", 'tasks.name as task_name');

        $totalRecordsWithFilter = $records->select("count({$tableName}.*) as allcount")->count();

        $records = $records->select("{$tableName}.*");
        if ($start !== '0') {
            $records = $records->skip($start);
        }
        $records = $records
            ->take($rowPerPage)
            ->orderBy('id', 'DESC')
            ->get();
        $dataArr = [];
        foreach ($records as $key => $record) {
            $dataArr[] = [
                'submitted_proof_image' => '<img src="' . $record->getFirstMediaUrl('image') . '" width="50" class="rounded" />',
                'username' => $record->createdBy?->username,
                'task_name' => $record->task?->task_name,
                'task_coins' => $record->task?->set_coins,
                'submitted_date' => $record->created_at,
                'status' => SubmissionStatusEnum::generateButton($record->status),
                'action' => $this->getActions($record)
            ];
        }

        return response()->json([
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $dataArr,
        ]);
    }

    private function getActions(Submission $record): string
    {
        $action = "";
        if ($record->status ===SubmissionStatusEnum::APPROVED){
            $action.='<a class="btn btn-danger btn-md disabled">
                <i class="fa-solid fa-check me-1"></i> ' . __('general.approved') . '
            </a>';
        }else{
            $action = '<div class="btn-group"><button type="button" class="btn btn-primary btn-md dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false" aria-haspopup="true">' . __('general.action') . '</button>
                    <ul class="dropdown-menu">';
            foreach (SubmissionStatusEnum::AdminSubmissionStatus() as $submission) {
                if ($record->status !== $submission){
                    $action .= '
                         <li>
                            <a class="dropdown-item" onclick="changeSubmissionStatus(this)" href="javascript:void(0)" data-type="' . $submission . '" data-id="' .$record->id. '"><i class="far fa-plus-circle"></i> ' .SubmissionStatusEnum::getTranslationKeyBy($submission) . '</a>
                        </li>';
                }
            }
        }
        return $action;
    }
}

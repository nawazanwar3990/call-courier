<?php

namespace App\Http\Requests;

use App\Enums\AbilityEnum;
use App\Enums\TableEnum;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BranchListRequest extends FormRequest
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
        $tableName = TableEnum::BRANCHES;

        $records = Branch::whereNull('tasks.deleted_at')
            ->whereHas('createdBy', function ($query) {
                $query->whereNull('users.deleted_at');
            })->with(['createdBy', 'updatedBy']);
        $draw = $this->get('draw');
        $start = $this->get("start");
        $rowPerPage = $this->get("length");
        $columnOrderArr = collect($this->get('order'));
        $columnsArr = collect($this->get('columns'));

        $isRowIdOrder = false;

        $columnOrderArr->each(function ($item, $key) use ($columnsArr, &$isRowIdOrder) {
            if ($columnsArr[$item['column']]['data'] == 'DT_RowId') {
                $isRowIdOrder = true;
            }
        });
        $searchValue = $this->get('search')['value'];

        $totalRecords = $records->select("count({$tableName}.*) as allcount")->count();

        $records = $records->when(strlen($searchValue), function (Builder $query) use ($searchValue, $tableName) {
            $query->where(function (Builder $q) use ($searchValue, $tableName) {
                $q->where("{$tableName}.name", 'like', DB::raw("'%$searchValue%'"))
                    ->orWhere("{$tableName}.description", 'like', DB::raw("'%$searchValue%'"));
            });
        });

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
                'thumbnail_image' => '<img src="' . $record->getFirstMediaUrl('picture') . '" width="50" class="rounded" />',
                'task_name' => $record->task_name,
                'task_url' => $record->task_url,
                'set_coins' => $record->set_coins,
                'status' => ($record->active === true ? '<span class="badge bg-success">' . __('general.active') . '</span>' : '<span class="badge bg-danger">' . __('general.in_active') . '</span>'),
                'task_limit' => $record->task_limit,
                'task_instruction' => $record->task_instruction,
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

    private function getActions(Branch $record): string
    {
        $action = '<div class="btn-group"><button type="button" class="btn btn-primary btn-md dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false" aria-haspopup="true">' . __('general.action') . '</button>
                    <ul class="dropdown-menu">';
        if (auth()->user()->can(AbilityEnum::UPDATE, Branch::class)) {
            $action .= '<li>
                            <a class="dropdown-item modal-edit-btn" href="javascript:void(0)" data-href="' . route('admin.branches.edit', $record->id) . '" data-init-select2="true">
                                <i class="fa-regular fa-pen-to-square me-2"></i>' . __('general.edit') . '
                            </a>
                        </li>';
        }
        if (Auth::user()->can(AbilityEnum::DELETE, Branch::class)) {
            $action .= '<li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item modal-delete-btn" href="javascript:void(0)" data-id="' . $record->id . '" data-href="' . route('admin.branches.destroy', $record->id) . '"><i class="far fa-trash"></i> ' . __('general.delete') . '</a>
                        </li>';
        }
        return $action;
    }
}

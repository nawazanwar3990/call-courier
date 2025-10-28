<?php

namespace App\Http\Requests;
use App\Enums\TableEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PermissionListRequest extends FormRequest
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
        $tableName = TableEnum::PERMISSIONS;

        $records = \App\Models\Permission::query();

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

        if ($isRowIdOrder) {
            $orderString = 'id asc';
        } else {
            $orderString = $columnOrderArr->map(function ($item, $key) use ($columnsArr) {
                return $columnsArr[$item['column']]['data'] . ' ' . $item['dir'];
            })->implode(', ');
        }

        $searchValue = $this->get('search')['value'];

        $totalRecords = $records->select("count({$tableName}.*) as allcount")->count();

        $records = $records->when(strlen($searchValue), function (Builder $query) use ($searchValue, $tableName) {
            $query->where(function (Builder $q) use ($searchValue, $tableName) {
                $q->where("{$tableName}.name", 'like', DB::raw("'%$searchValue%'"))
                    ->orWhere("{$tableName}.label", 'like', DB::raw("'%$searchValue%'"));
            });
        });

        $totalRecordsWithFilter = $records->select("count({$tableName}.*) as allcount")->count();

        $records = $records->select("{$tableName}.*")->orderByRaw($orderString);
        if ($start !== '0') {
            $records = $records->skip($start);
        }

        $records = $records->take($rowPerPage)->get();
        $dataArr = [];

        foreach ($records as $key => $record) {
            $dataArr[] = [
                'name' => $record->name,
                'label' => $record->label,
            ];
        }

        return response()->json([
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $dataArr,
        ]);
    }
}

<?php

namespace App\Http\Requests;

use App\Enums\NotificationPositionEnum;
use App\Enums\TableEnum;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationListRequest extends FormRequest
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
        $tableName = TableEnum::NOTIFICATIONS;

        $records = Notification::where('notifiable_id', auth()->id())->whereNull('read_at')->latest();

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
                $q->where("{$tableName}.type", 'like', DB::raw("'%$searchValue%'"));
            });
        });

        $totalRecordsWithFilter = $records->select("count({$tableName}.*) as allcount")->count();

        $records = $records->select("{$tableName}.*")->orderByRaw($orderString);
        if ($start !== '0') {
            $records = $records->skip($start);
        }
        $records = $records->take($rowPerPage)
            ->get();

        $dataArr = [];

        foreach ($records as $key => $record) {
            $dataArr[] = [
                'action' => $this->getActions($record),
                'type' => $record->data['heading'],
                'created_at' => Carbon::parse($record->created_at)->format('d-M-Y h:i:s a'),
                'message' => $record->data['description'],
            ];
        }

        return response()->json([
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $dataArr,
        ]);
    }

    private function getActions(Notification $record): string
    {
        return '<button type="button" class="btn btn-md btn-success"
                        onclick="readNotification(null, \'' . $record->id . '\',\'' . NotificationPositionEnum::ADMIN_LIST . '\',event);">
                    <i class="fa-regular fa-envelope-open me-1"></i>' . __('general.mark_as_read') . '
                </button>';
    }
}

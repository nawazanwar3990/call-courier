<?php

namespace App\Http\Requests;

use App\Enums\PasswordResetStatusEnum;
use App\Enums\RedeemStatusEnum;
use App\Enums\TableEnum;
use App\Models\PasswordReset;
use App\Models\Redeem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PasswordResetListRequest extends FormRequest
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
        $records = PasswordReset::with('createdBy', 'updatedBy');

        $draw = $this->get('draw');
        $start = $this->get("start");
        $rowPerPage = $this->get("length");
        $status = $this->get('status');

        $columnOrderArr = collect($this->get('order'));
        $columnsArr = collect($this->get('columns'));

        $isRowIdOrder = false;

        $columnOrderArr->each(function ($item) use ($columnsArr, &$isRowIdOrder) {
            if ($columnsArr[$item['column']]['data'] == 'DT_RowId') {
                $isRowIdOrder = true;
            }
        });

        $orderString = $isRowIdOrder
            ? 'id asc'
            : $columnOrderArr->map(function ($item) use ($columnsArr) {
                return $columnsArr[$item['column']]['data'] . ' ' . $item['dir'];
            })->implode(', ');

        $searchValue = $this->get('search')['value'];

        if ($status) {
            $records = $records->where('status', $status);
        }

        $records = $records->when(strlen($searchValue), function (Builder $query) use ($searchValue) {
            $query->where(function (Builder $q) use ($searchValue) {
                $q->whereHas('giftCard', function (Builder $typeQuery) use ($searchValue) {
                    $typeQuery->where('name', 'like', "%{$searchValue}%");
                });
            });
        });

        $totalRecords = $records->count();
        $totalRecordsWithFilter = $records->count();

        $records = $records->orderByRaw($orderString)
            ->when($start !== '0', fn($query) => $query->skip($start))
            ->take($rowPerPage)
            ->get();

        $dataArr = [];
        foreach ($records as $record) {
            $row = [
                'created_by' => $record->createdBy?->email ?? '-',
                'action' => $this->getActions($record),
            ];

            if ($status == \App\Enums\RedeemStatusEnum::REQUESTED) {
                $row['created_at'] = $record->created_at;
            }else{
                $row['updated_at'] = $record->updated_at;
            }

            $dataArr[] = $row;
        }

        return response()->json([
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $dataArr,
        ]);
    }

    private function getActions(PasswordReset $record): string
    {
        if ($record->status === PasswordResetStatusEnum::PROCESSED) {
            return '
            <a class="btn btn-danger btn-md disabled">
                <i class="fa-solid fa-check me-1"></i> ' . __('general.processed') . '
            </a>';
        } else {
            return '
            <a href="' . route('admin.password.change',$record->id) . '" class="btn btn-success btn-md text-white">
                <i class="fa-solid fa-plus-circle me-1"></i> ' . __('general.change') . '
            </a>';
        }
    }
}

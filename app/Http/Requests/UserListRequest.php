<?php

namespace App\Http\Requests;

use App\Enums\AbilityEnum;
use App\Enums\RoleEnum;
use App\Enums\TableEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserListRequest extends FormRequest
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
        $tableName = TableEnum::USERS;

        $records = User::whereHas('roles', function ($query) {
            $query->where('name', RoleEnum::ROLE_USER);
        });

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
                $q->where("{$tableName}.username", 'like', "%{$searchValue}%")
                    ->orWhere("{$tableName}.email", 'like', "%{$searchValue}%")
                    ->orWhere("{$tableName}.mobile", 'like', "%{$searchValue}%");
            });
        });

        $totalRecordsWithFilter = $records->select("count({$tableName}.*) as allcount")->count();

        $records = $records->select("{$tableName}.*")->orderByRaw($orderString);
        if ($start !== '0') {
            $records = $records->skip($start);
        }
        $records = $records
            ->with([
                'roles:id,name',
                'media',
            ])
            ->take($rowPerPage)
            ->get();

        $dataArr = [];
        foreach ($records as $record) {
            $photoUrl = $record->getFirstMediaUrl('picture') ?: asset('assets/img/user-picture.jpg');

            $dataArr[] = [
                'photo' => '<img src="' . e($photoUrl) . '" onerror="this.src=\'' . asset('assets/img/user-picture.jpg') . '\'" width="50" class="rounded" />',
                'username' => e($record->username),
                'email' => e($record->email),
                'mobile' => e($record->mobile),
                'active' => $record->active
                    ? '<span class="badge bg-success">' . __('general.active') . '</span>'
                    : '<span class="badge bg-danger">' . __('general.in_active') . '</span>',
                'action' => $this->getActions($record),
            ];
        }

        return response()->json([
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $dataArr,
        ]);
    }

    private function getActions(User $record): string
    {

        $action = '<div class="btn-group"><button type="button" class="btn btn-primary btn-md dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false" aria-haspopup="true">' . __('general.actions') . '</button>
                <ul class="dropdown-menu">';
        if (auth()->user()->can(AbilityEnum::UPDATE, User::class)) {
            $action .= '<li>
                                <a class="dropdown-item modal-edit-btn" href="javascript:void(0)" data-href="' . route('admin.users.edit', $record->id) . '" data-init-select2="true">
                                    <i class="fa-regular fa-pen-to-square me-2"></i>' . __('general.edit') . '
                                </a>
                            </li>';
        }

        if (Auth::user()->can(AbilityEnum::DELETE, User::class)) {
            $action .= '<li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item modal-delete-btn" href="javascript:void(0)" data-id="' . $record->id . '" data-href="' . route('admin.users.destroy', $record->id) . '"><i class="far fa-trash"></i> ' . __('general.delete') . '</a>
                        </li>';
        }
        $action .= '</ul></div>';

        return $action;
    }
}

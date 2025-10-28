<?php

namespace App\Http\Requests;

use App\Enums\AbilityEnum;
use App\Enums\RoleEnum;
use App\Enums\TableEnum;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleListRequest extends FormRequest
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
        $tableName = TableEnum::ROLES;

        $records = Role::query()->where('label', '!=', RoleEnum::ROLE_SUPER_ADMIN);

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
        $records = $records
            ->withCount([
                'permissions',
            ])
            ->with([
                'users:id,username' => [
                    'media',
                ],
            ])
            ->take($rowPerPage)
            ->get();

        $dataArr = [];

        foreach ($records as $key => $record) {
            $roleUsers = '<ul class="list-unstyled d-flex align-items-center avatar-group mb-0">';
            foreach ($record->users as $roleUser) {
                $roleUsers .= '<li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="' . $roleUser->username . '" class="avatar avatar-sm pull-up">
                  <img class="rounded-circle" src="' . $roleUser->getFirstMediaUrl('picture') . '" alt="Avatar">
                </li>';
            }
            $roleUsers .= '</ul>';

            $dataArr[] = [
                'action' => $this->getActions($record),
                'name' => $record->name,
                'permissions' => $record->permissions_count,
                'users' => $roleUsers,
            ];
        }

        return response()->json([
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $dataArr,
        ]);
    }

    private function getActions(Role $record): string
    {
        $action = '<div class="btn-group"><button type="button" class="btn btn-primary btn-md dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false" aria-haspopup="true">' . __('general.action') . '</button>
                    <ul class="dropdown-menu">';
        if (Auth::user()->can(AbilityEnum::UPDATE, Role::class)) {
            $action .= '<li>
                                <a  class="dropdown-item" href="' . route('admin.role-users.index', ['role' => $record->id]) . '"><i class="far fa-users"></i> ' . __('general.users') . '</a>
                            </li>
                            <li>
                                <a  class="dropdown-item" href="' . route('admin.role-permissions.index', ['role' => $record->id]) . '"><i class="far fa-shield-check"></i> ' . __('general.permissions') . '</a>
                            </li>';
        }
        return $action;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AbilityEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionListRequest;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    public function index(PermissionListRequest $request)
    {
        Gate::authorize(AbilityEnum::LIST, Permission::class);

        if ($request->ajax()) {
            return $request->processRequest();
        }

        $params = [
            'pageTitle' => __('general.permissions'),
            'breadCrumbs' => collect([
                __('general.dashboard') => route('admin.dashboard'),
                __('general.permissions') => '',
            ]),
        ];

        return view('admin.permission.index', $params);
    }
}

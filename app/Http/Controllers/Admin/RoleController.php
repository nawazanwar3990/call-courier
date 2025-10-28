<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AbilityEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleListRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
class RoleController extends Controller
{
    public function index(RoleListRequest $request)
    {
        Gate::authorize(AbilityEnum::LIST, Role::class);
        if ($request->ajax()) {
            return $request->processRequest();
        }
        $params = [
            'pageTitle' => __('general.roles'),
            'breadCrumbs' => collect([
                __('general.dashboard') => route('admin.dashboard'),
                __('general.roles') => '',
            ]),
        ];
        return view('admin.role.index', $params);
    }
}

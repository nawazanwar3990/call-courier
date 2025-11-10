<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $isUser = UserService::hasRole(RoleEnum::ROLE_USER);
        if (!$isUser) {
            return redirect()->route('admin.users.index');
        }

        $params = [
            'pageTitle' => __('general.dashboard'),
            'breadCrumbs' => collect([
                __('general.dashboard') => route('admin.dashboard'),
                __('general.dashboard') => '',
            ]),
            'isUser' => $isUser,
        ];

        return view('dashboard', $params);
    }
}

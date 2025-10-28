<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function index()
    {
        $params = [
            'pageTitle' => __('general.profile'),
            'breadCrumbs' => [
                __('general.dashboard') => route('admin.dashboard'),
                __('general.profile') => '',
            ],
        ];

        return view('admin.user.profile', $params);
    }

    public function store(ProfileRequest $request): JsonResponse
    {
        $return = $request->saveRecord();
        if ($return['success'] === true) {
            return response()->json(['success' => true, 'msg' => $return['msg']]);
        }

        return response()->json(['success' => false, 'msg' => $return['msg']]);
    }
}

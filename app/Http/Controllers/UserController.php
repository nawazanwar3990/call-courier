<?php

namespace App\Http\Controllers;

use App\Enums\AbilityEnum;
use App\Http\Requests\UserListRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(UserListRequest $request)
    {
        Gate::authorize(AbilityEnum::LIST, User::class);

        if ($request->ajax()) {
            return $request->processRequest();
        }

        $params = [
            'pageTitle' => __('general.users'),
            'breadCrumbs' => collect([
                __('general.dashboard') => route('admin.dashboard'),
                __('general.users') => '',
            ]),
        ];
        return view('admin.user.index', $params);
    }

    public function create()
    {
        Gate::authorize(AbilityEnum::CREATE, User::class);

        $params = [
            'pageTitle' => __('general.new_user'),
        ];
        return view('admin.user.create', $params);
    }

    public function store(UserRequest $request): JsonResponse
    {
        Gate::authorize(AbilityEnum::CREATE, User::class);

        return response()->json($request->saveRecord());
    }
    public function edit($id)
    {
        Gate::authorize(AbilityEnum::UPDATE, User::class);

        $user = User::with([
                'updatedBy:id,username',
            ])
            ->findOrFail($id);

        $params = [
            'pageTitle' => __('general.edit_user') . ' : ' . $user->username,
            'model' => $user,
        ];
        return view('admin.user.edit', $params);
    }

    public function update(UserRequest $request, $id): JsonResponse
    {
        Gate::authorize(AbilityEnum::UPDATE, User::class);

        return response()->json($request->updateRecord($id));
    }

    public function destroy(UserRequest $request, $id): JsonResponse
    {
        Gate::authorize(AbilityEnum::DELETE, User::class);
        return response()->json($request->deleteRecord($id));
    }
    public function updateTheme(Request $request): JsonResponse
    {
        $user = auth()->user();
        $user->theme = $request->get('theme');
        $user->save();
        return response()->json(['success' => true]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Cache::flush();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.dashboard');
    }
}

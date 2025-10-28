<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AbilityEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\BranchListRequest;
use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class BranchController extends Controller
{
    public function index(BranchListRequest $request)
    {
        Gate::authorize(AbilityEnum::LIST, Branch::class);
        if ($request->ajax()) {
            return $request->processRequest();
        }
        $params = [
            'pageTitle' => __('general.branches'),
            'breadCrumbs' => collect([
                __('general.dashboard') => route('admin.dashboard'),
                __('general.branches') => '',
            ]),
        ];

        return view('admin.branches.index', $params);
    }

    public function create()
    {
        Gate::authorize(AbilityEnum::CREATE, Branch::class);

        $params = [
            'pageTitle' => __('general.new_branch'),
        ];
        return view('admin.branches.create', $params);
    }

    public function store(BranchRequest $request): JsonResponse
    {
        Gate::authorize(AbilityEnum::CREATE, Branch::class);
        return response()->json($request->saveRecord());
    }

    public function show($id)
    {
        Gate::authorize(AbilityEnum::VIEW, Branch::class);
    }

    public function edit($id)
    {
        Gate::authorize(AbilityEnum::UPDATE, Branch::class);
        $branch = Branch::with(['updatedBy:id,username'])->findOrFail($id);
        $params = [
            'pageTitle' => __('general.edit_branch') . ' : ' . $branch->name,
            'model' => $branch,
        ];
        return view('admin.branches.edit', $params);
    }

    public function update(BranchRequest $request, $id): JsonResponse
    {
        Gate::authorize(AbilityEnum::UPDATE, Branch::class);
        return response()->json($request->updateRecord());
    }

    public function destroy(BranchRequest $request, $id): JsonResponse
    {
        Gate::authorize(AbilityEnum::DELETE, Branch::class);
        return response()->json($request->deleteRecord($id));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AbilityEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\DataListRequest;
use App\Http\Requests\DataRequest;
use App\Models\Data;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class DataController extends Controller
{
    public function index(Request $request)
    {
        $data = null;

        if ($request->has('s')) {
            $data = Data::with('user')
                ->when($request->filled('bId'), function ($query) use ($request) {
                    $query->whereHas('user', function ($q) use ($request) {
                        $q->where('branch_id', $request->bId);
                    });
                })
                ->when($request->filled('date'), function ($query) use ($request) {
                    $query->whereDate('created_at', $request->date);
                })
                ->get();
        }
        $params = [
            'pageTitle' => 'Scanned Data',
            'breadCrumbs' => collect([
                __('general.dashboard') => route('admin.dashboard'),
                'Data' => '',
            ]),
            'bId' => $request->query('bId', ''),
            'date' => $request->query('date', ''),
            's'=>$request->query('s'),
        ];

        if ($data) {
            $params['data'] = $data;
        }

        return view('admin.data.index', $params);
    }
    public function store(DataRequest $request): RedirectResponse
    {
        $request->saveRecords();
        return redirect()->back()->with('success','Record Added Successfully');
    }
}

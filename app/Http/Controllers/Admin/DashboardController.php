<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
class DashboardController extends Controller
{
    public function dashboard()
    {
        return redirect()->route('admin.users.index');
    }
}

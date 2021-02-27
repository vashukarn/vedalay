<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Information;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {

    }

    public function index(){
        $usertotal = User::selectRaw('count(*) as total')
        ->selectRaw("count(case when type = 'superadmin' then 1 end) as superadmincount")
        ->selectRaw("count(case when type = 'student' then 1 end) as studentcount")
        ->selectRaw("count(case when type = 'admin' then 1 end) as admincount")
        ->selectRaw("count(case when type = 'teacher' then 1 end) as teachercount")
        ->selectRaw("count(case when type = 'staff' then 1 end) as staffcount")
        ->first();
        
        $data = [
            'usertotal' => $usertotal,
        ];

        return view('admin.dashboard')->with($data);
    }

}

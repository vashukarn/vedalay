<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdvanceSalary;
use App\Models\Feature;
use App\Models\Information;
use App\Models\Salary;
use App\Models\Slider;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {

    }

    public function index(){
        $daycount = 0;
        $id = Auth::user()->id;
        $type = Auth::user()->type;
        if($type == 'teacher'){
            $teacher = Teacher::where('user_id', $id)->first();
            $subjectcount = Subject::where('id',$teacher->subject)->count();
            $advancesalary = AdvanceSalary::where('user_id',$id)->sum('amount');
            $tempo = Salary::where('user_id',$id)->get();
            $paidsalary = 0;
            $extraclass = 0;
            foreach ($tempo as $key => $value) {
                $paidsalary += $value->salary['total_amount'];
                $extraclass += $value->salary['extra_class_salary'];
            }
            $now = Carbon::now();
            $lastdate = Carbon::parse($now)->endOfMonth();
            $daycount = ($lastdate->diff($now)->days < 1)
                ? 'Today'
                : $lastdate->diffForHumans($now);
        }
        if($type == 'staff'){
            $advancesalary = AdvanceSalary::where('user_id',$id)->sum('amount');
            $tempo = Salary::where('user_id',$id)->get();
            $paidsalary = 0;
            $incentives = 0;
            foreach ($tempo as $key => $value) {
                $paidsalary += $value->salary['total_amount'];
                $incentives += $value->salary['incentive'];
            }
            $now = Carbon::now();
            $lastdate = Carbon::parse($now)->endOfMonth();
            $daycount = ($lastdate->diff($now)->days < 1)
                ? 'Today'
                : $lastdate->diffForHumans($now);
        }
        if($type == 'admin' || $type == 'superadmin'){
            $usertotal = User::selectRaw('count(*) as total')
            ->selectRaw("count(case when type = 'superadmin' then 1 end) as superadmincount")
            ->selectRaw("count(case when type = 'student' then 1 end) as studentcount")
            ->selectRaw("count(case when type = 'admin' then 1 end) as admincount")
            ->selectRaw("count(case when type = 'teacher' then 1 end) as teachercount")
            ->selectRaw("count(case when type = 'staff' then 1 end) as staffcount")
            ->first();
        }
        
        $data = [
            'usertotal' => $usertotal ?? null,
            'subjectcount' => $subjectcount ?? null,
            'daycount' => str_split($daycount)[0] ?? null,
            'advancesalary' => $advancesalary ?? null,
            'paidsalary' => $paidsalary ?? null,
            'incentives' => $incentives ?? null,
            'extraclass' => $extraclass ?? null,
        ];

        return view('admin.dashboard')->with($data);
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\AdvanceSalary;
use App\Models\Attendance;
use App\Models\Fee;
use App\Models\Salary;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        if($type == 'student'){
            $total_attendance = 0;
            $student_attendance = 0;
            $due_fee = 0;
            $student = Student::where('user_id', $id)->first();
            $tempoo = Attendance::where('holiday', '0')->where('level_id', $student->level_id)->get();
            $tempooo = Fee::where('rollback', '0')->where('student_id', $id)->get();

            foreach ($tempooo as $key => $value) {
                $due_fee += $value->fees['total_amount'];
            }
            if(count($tempoo) > 0){
                foreach ($tempoo as $key => $value) {
                    foreach ($value->students as $key => $item) {
                        if($key == $id){
                            $total_attendance++;
                            if($item == '1')
                            $student_attendance++;
                        }
                    }
                }
                $attendance_percentage = ($student_attendance*100)/$total_attendance;
            }
        }
        if($type == 'admin' || $type == 'superadmin'){
            $usertotal = User::selectRaw('count(*) as total')
            ->selectRaw("count(case when type = 'superadmin' then 1 end) as superadmincount")
            ->selectRaw("count(case when type = 'student' then 1 end) as studentcount")
            ->selectRaw("count(case when type = 'admin' then 1 end) as admincount")
            ->selectRaw("count(case when type = 'teacher' then 1 end) as teachercount")
            ->selectRaw("count(case when type = 'staff' then 1 end) as staffcount")
            ->first();
            $admissions = Admission::count();
        }
        
        $data = [
            'usertotal' => $usertotal ?? null,
            'subjectcount' => $subjectcount ?? null,
            'daycount' => str_split($daycount)[0] ?? null,
            'advancesalary' => $advancesalary ?? null,
            'paidsalary' => $paidsalary ?? null,
            'incentives' => $incentives ?? null,
            'extraclass' => $extraclass ?? null,
            'attendance_percentage' => $attendance_percentage ?? null,
            'due_fee' => $due_fee ?? null,
            'admissions' => $admissions ?? null,
        ];

        return view('admin.dashboard')->with($data);
    }

}

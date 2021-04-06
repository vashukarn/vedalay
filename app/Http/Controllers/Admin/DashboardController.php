<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\AdvanceSalary;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Fee;
use App\Models\Leave;
use App\Models\NoticeBoard;
use App\Models\Notification;
use App\Models\Salary;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $leaves = Leave::where('created_by', $user->id)->where('status', 'ACCEPTED')->count();
        if ($user->roles->first()->name == 'Super Admin' || 'Admin') {
            $usertotal = User::selectRaw('count(*) as total')
                ->selectRaw("count(case when type = 'superadmin' then 1 end) as superadmincount")
                ->selectRaw("count(case when type = 'student' then 1 end) as studentcount")
                ->selectRaw("count(case when type = 'admin' then 1 end) as admincount")
                ->selectRaw("count(case when type = 'teacher' then 1 end) as teachercount")
                ->selectRaw("count(case when type = 'staff' then 1 end) as staffcount")
                ->first();
            $admission = [];
            $temp = Admission::orderBy('id', 'DESC')->limit(12)->get();
            foreach ($temp as $key => $value) {
                $admission[$value->id] = [
                    'image' => $value->get_student->image,
                    'join_date' => $value->get_user->created_at,
                    'name' => $value->get_user->name,
                ];
            }
            $attemptoday = Attendance::whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->get();
            $attempall = Attendance::whereMonth('created_at', Carbon::now()->month)->get();
            $totalstudtoday = 0;
            $presentstudtoday = 0;
            $absentstudtoday = 0;
            $totalstudall = 0;
            $presentstudall = 0;
            $absentstudall = 0;
            foreach ($attemptoday as $key => $value) {
                foreach ($value->students as $key => $value) {
                    if($value == '1'){
                        $presentstudtoday++;
                    }
                    else{
                        $absentstudtoday++;
                    }
                    $totalstudtoday++;
                }
            }
            foreach ($attempall as $key => $value) {
                foreach ($value->students as $key => $value) {
                    if($value == '1'){
                        $presentstudall++;
                    }
                    else{
                        $absentstudall++;
                    }
                    $totalstudall++;
                }
            }
            $todayattendancesummary = [
                'total' => $totalstudtoday,
                'absent' => $absentstudtoday,
                'present' => $presentstudtoday,
            ];
            $allattendancesummary = [
                'total' => $totalstudall,
                'absent' => $absentstudall,
                'present' => $presentstudall,
            ];
            // dd($allattendancesummary);
            $data = [
                'usertotal' => $usertotal,
                'attendancetoday' => $todayattendancesummary,
                'attendanceall' => $allattendancesummary,
                'leaves' => $leaves,
                'admission' => $admission,
                'notices' => NoticeBoard::select('id', 'title')->where('publish_status', '1')->latest()->count(),
            ];
        }
        if ($user->roles->first()->name == 'Teacher') {
            $teacher = Teacher::where('user_id', $user->id)->first();
            $subjectcount = Subject::whereIn('id', $teacher->subject)->count();
            $advancesalary = AdvanceSalary::where('user_id', $user->id)->sum('amount');
            $tempo = Salary::where('user_id', $user->id)->get();
            $paidsalary = 0;
            $extraclass = 0;
            foreach ($tempo as $key => $value) {
                $paidsalary += $value->total_amount;
                $extraclass += $value->extra_class;
            }
            $data = [
                'subjectcount' => $subjectcount ?? null,
                'advancesalary' => $advancesalary ?? null,
                'paidsalary' => $paidsalary ?? null,
                'incentives' => $incentives ?? null,
                'leaves' => $leaves ?? null,
                'extraclass' => $extraclass ?? null,
                'assignment' => $assignment ?? null,
                'attendance_percentage' => $attendance_percentage ?? null,
                'due_fee' => $due_fee ?? null,
                'admission' => $admission ?? null,
                'notices' => NoticeBoard::select('id', 'title')->where('publish_status', '1')->latest()->count(),
            ];
        }
        if ($user->roles->first()->name == 'Staff') {
            $advancesalary = AdvanceSalary::where('user_id', $user->id)->sum('amount');
            $tempo = Salary::where('user_id', $user->id)->get();
            $paidsalary = 0;
            $incentives = 0;
            foreach ($tempo as $key => $value) {
                $paidsalary += $value->total_amount;
                $incentives += $value->incentive;
            }
            $data = [
                'usertotal' => $usertotal ?? null,
                'subjectcount' => $subjectcount ?? null,
                'advancesalary' => $advancesalary ?? null,
                'paidsalary' => $paidsalary ?? null,
                'incentives' => $incentives ?? null,
                'leaves' => $leaves ?? null,
                'extraclass' => $extraclass ?? null,
                'assignment' => $assignment ?? null,
                'attendance_percentage' => $attendance_percentage ?? null,
                'due_fee' => $due_fee ?? null,
                'admission' => $admission ?? null,
                'notices' => NoticeBoard::select('id', 'title')->where('publish_status', '1')->latest()->count(),
            ];
        }
        if ($user->roles->first()->name == 'Student') {
            $total_attendance_year = 0;
            $student_attendance_year = 0;
            $total_attendance_month = 0;
            $student_attendance_month = 0;
            $due_fee = 0;
            $assignment = 0;
            $student = Student::where('user_id', $user->id)->first();
            $trunt = Assignment::where('deadline', '>=', date('Y-m-d'))->get();
            foreach ($trunt as $value) {
                if ($value->get_subject->get_level->id == $student->level_id) {
                    $assignment++;
                }
            }
            $attendtempyear = Attendance::whereYear('created_at', Carbon::now()->year)->where('holiday', '0')->where('level_id', $student->level_id)->get();
            $attendtempmonth = Attendance::whereMonth('created_at', Carbon::now()->month)->where('holiday', '0')->where('level_id', $student->level_id)->get();
            $feetemp = Fee::where('rollback', '0')->where('student_id', $user->id)->get();

            foreach ($feetemp as $item) {
                $due_fee += $item->total_amount;
            }
            $attendance_percentage_year = 0;
            $attendance_percentage_month = 0;
            if (count($attendtempyear) > 0) {
                foreach ($attendtempyear as $temp) {
                    if (count($temp->students) > 0) {
                        foreach ($temp->students as $key => $item) {
                            if ($key == $user->id) {
                                $total_attendance_year++;
                                if ($item == '1')
                                    $student_attendance_year++;
                            }
                        }
                    }
                }
                $attendance_percentage_year = ($student_attendance_year * 100) / $total_attendance_year;
            }
            if (count($attendtempmonth) > 0) {
                foreach ($attendtempmonth as $temp) {
                    if (count($temp->students) > 0) {
                        foreach ($temp->students as $key => $item) {
                            if ($key == $user->id) {
                                $total_attendance_month++;
                                if ($item == '1')
                                    $student_attendance_month++;
                            }
                        }
                    }
                }
                $attendance_percentage_month = ($student_attendance_month * 100) / $total_attendance_month;
            }
            $data = [
                'leaves' => $leaves,
                'assignment' => $assignment,
                'attendance_percentage_year' => $attendance_percentage_year,
                'attendance_percentage_month' => $attendance_percentage_month,
                'due_fee' => $due_fee,
                'notices' => NoticeBoard::select('id', 'title')->where('publish_status', '1')->latest()->count(),
            ];
        }

        return view('admin.dashboard')->with($data);
    }

    public function clearNotification(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            Notification::where('user_id', $id)->delete();
            DB::commit();
            $request->session()->flash('success', 'Notification cleared successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            $request->session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}

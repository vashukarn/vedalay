<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\AdvanceSalary;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Expense;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Leave;
use App\Models\NoticeBoard;
use App\Models\Notification;
use App\Models\Salary;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
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

            // dd(Expense::pluck('title'));
            $data = [
                'usertotal' => $usertotal,
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
            $total_attendance = 0;
            $student_attendance = 0;
            $due_fee = 0;
            $assignment = 0;
            $student = Student::where('user_id', $user->id)->first();
            $trunt = Assignment::where('deadline', '>=', date('Y-m-d'))->get();
            foreach ($trunt as $value) {
                if ($value->get_subject->get_level->id == $student->level_id) {
                    $assignment++;
                }
            }
            $attendtemp = Attendance::where('holiday', '0')->where('level_id', $student->level_id)->get();
            $feetemp = Fee::where('rollback', '0')->where('student_id', $user->id)->get();

            foreach ($feetemp as $item) {
                $due_fee += $item->total_amount;
            }
            if (count($attendtemp) > 0) {
                foreach ($attendtemp as $temp) {
                    if (count($temp->students) > 0) {
                        foreach ($temp->students as $key => $item) {
                            if ($key == $user->id) {
                                $total_attendance++;
                                if ($item == '1')
                                    $student_attendance++;
                            }
                        }
                    }
                }
                $attendance_percentage = ($student_attendance * 100) / $total_attendance;
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

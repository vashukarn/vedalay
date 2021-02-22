<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function takeAttendance($id)
    {
        $subject = Subject::find($id);
        $students = Student::where('level_id', $subject->level_id)->get();
        $title = 'Mark Attendance';
        $data = [
            'title' => $title,
            'student_info' => $students,
            'subject_info' => $subject,
            'attendance_info' => null,
        ];
        return view('admin/attendance/form')->with($data);
    }
    public function attendanceList($id)
    {
        $subject = Subject::pluck('title', 'id');
        $students = User::pluck('name', 'id');
        $attendance_info = Attendance::where('subject_id',$id)->paginate(20);
        $title = 'Attendance List';
        $data = [
            'title' => $title,
            'subject' => $subject,
            'data' => $attendance_info,
            'students' => $students,
        ];
        return view('admin/attendance/list')->with($data);
    }
    public function updateAttendance(Request $request)
    {
        try {
            $students = [];
            foreach ($request->attendance as $key => $value) {
                if(isset($value)){
                    $students[$key] = $value;
                }
            }
            $find = Attendance::where('subject_id', $request->subject)->whereBetween('created_at', [date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')])->first();
            if(isset($find)){
                $find->students = $students;
                $find->updated_by = Auth::user()->id;
                $find->save();
            }
            else{
                $attendance = Attendance::create([
                    'subject_id' => $request->subject,
                    'level_id' => $request->level,
                    'students' => $students,
                    'holiday_reason' => $request->holiday_reason ?? null,
                    'holiday' => $request->holiday_reason ? 1 : 0,
                    'created_by' => Auth::user()->id,
                ]);
            }
        } catch (Exception $e) {
            $attendance = $e->message;
        }
        return response()->json($attendance);
    }
    public function index()
    {
        $subject = Subject::pluck('title', 'id');
        $students = User::pluck('name', 'id');
        $attendance_info = Attendance::paginate(20);
        $title = 'Attendance List';
        $data = [
            'title' => $title,
            'subject' => $subject,
            'data' => $attendance_info,
            'students' => $students,
        ];
        return view('admin/attendance/list')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

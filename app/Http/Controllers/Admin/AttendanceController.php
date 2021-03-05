<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function __construct(Attendance $attendance)
    {
        $this->middleware(['permission:attendance-list|attendance-create|attendance-edit|attendance-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:attendance-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:attendance-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:attendance-delete'], ['only' => ['destroy']]);
        $this->attendance = $attendance;
    }
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
            $attendance = null;
            if(isset($find)){
                $find->level_id = htmlentities($request->level);
                $find->students = $students;
                $find->holiday = htmlentities($request->holiday);
                $find->holiday_reason = htmlentities($request->holiday_reason);
                $find->updated_by = Auth::user()->id;
                $find->save();
                $attendance = "Attendance Updated Successfully";
            }
            else{
                DB::beginTransaction();
                $attendance = Attendance::create([
                    'subject_id' => htmlentities($request->subject),
                    'level_id' => htmlentities($request->level),
                    'students' => $students ?? null,
                    'holiday_reason' => htmlentities($request->holiday_reason ?? null),
                    'holiday' => htmlentities($request->holiday) == 1 ? '1' : '0',
                    'created_by' => Auth::user()->id,
                ]);
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $attendance = $e->message;
        }
        return response()->json($attendance);
    }
    protected function getAttendance($request)
    {
        $query = $this->attendance->orderBy('id', 'DESC');

        if(Auth::user()->roles->pluck('name')[0] == 'Teacher'){
            $subjects = Teacher::where('user_id', Auth::user()->id)->pluck('subject')->first();
            $query = $query->whereIn('subject_id', $subjects);
        }

        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('user_id', $keyword);
        }
        
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $subject = Subject::pluck('title', 'id');
        $students = User::where('type', 'student')->pluck('name', 'id');
        $attendance_info = $this->getAttendance($request);
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

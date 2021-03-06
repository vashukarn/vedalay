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

    public function store(Request $request)
    {
        $this->validate($request, [
            'subject_id' => 'required|numeric',
            'level_id' => 'required|numeric',
            'attendance' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $find = Attendance::where('subject_id', $request->subject_id)->whereBetween('created_at', [date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')])->first();
            if(isset($find)){
                $find->students = $request->attendance;
                $find->updated_by = Auth::user()->id;
                $find->save();
                DB::commit();
                $request->session()->flash('success', 'Attendance updated successfully.');
                return redirect()->route('attendance.index');
            }
            else{
            Attendance::create([
                'subject_id' => htmlentities($request->subject_id),
                'level_id' => htmlentities($request->level_id),
                'students' => $request->attendance,
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            $request->session()->flash('success', 'Attendance marked successfully.');
            return redirect()->route('attendance.index');
        }
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
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

}

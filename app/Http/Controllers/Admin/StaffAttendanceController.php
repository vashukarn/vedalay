<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffAttendance;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAttendanceController extends Controller
{
    public function __construct(StaffAttendance $staffattendance)
    {
        $this->middleware(['permission:staffattendance-list|staffattendance-create|staffattendance-edit|staffattendance-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:staffattendance-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:staffattendance-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:staffattendance-delete'], ['only' => ['destroy']]);
        $this->staffattendance = $staffattendance;
    }
    protected function getstaffattendance($request)
    {
        $query = $this->staffattendance->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getstaffattendance($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/staffattendance/list')->with($data);
    }

    public function create()
    {
        $staffattendance_info = null;
        $employee_info = User::whereIn('type', ['teacher','staff'])->where('publish_status', '1')->get();
        $title = 'Mark Employee Attendance';
        $data = [
            'title' => $title,
            'staffattendance_info' => $staffattendance_info,
            'employee_info' => $employee_info,
        ];
        return view('admin/staffattendance/form')->with($data);
    }

    public function store(Request $request)
    {
        try {
            $students = [];
            foreach ($request->attendance as $key => $value) {
                if(isset($value)){
                    $students[$key] = $value;
                }
            }
            if(isset($find)){
                $attendance = "Attendance Already Marked";
            }
            else{
                $attendance = StaffAttendance::create([
                    'students' => $students,
                    'created_by' => Auth::user()->id,
                ]);
            }
        } catch (Exception $e) {
            $attendance = $e->message;
        }
        return response()->json($attendance);
    }
}

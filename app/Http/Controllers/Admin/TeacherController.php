<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function __construct(Teacher $teacher)
    {
        $this->middleware(['permission:teacher-list|teacher-create|teacher-edit|teacher-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:teacher-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:teacher-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:teacher-delete'], ['only' => ['destroy']]);
        $this->teacher = $teacher;
    }
    protected function getTeacher($request)
    {
        $query = $this->teacher->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $subjects = Subject::pluck('title', 'id');
        $data = $this->getTeacher($request);
        $data = [
            'data' => $data,
            'subjects' => $subjects,
        ];
        return view('admin/teacher/list')->with($data);
    }

    public function create()
    {
        $teacher_info = null;
        $title = 'Add Teacher';
        $temp = Subject::where('publish_status', '1')->get();
        $subjects = null;
        foreach ($temp as $value) {
            $subjects[$value->id] = $value->title.' - Level: ' .$value->get_level->standard;
        }
        $data = [
            'title' => $title,
            'teacher_info' => $teacher_info,
            'subjects' => $subjects,
        ];
        return view('admin/teacher/form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
            'email' => 'required|unique:users|string|min:3|max:190',
            'phone' => 'required|string|min:10|max:10',
            'gender' => 'required',
            'subject' => 'required',
            'password' => 'required|required_with:confirm_password|same:confirm_password|min:8|max:190',
            'permanent_address' => 'required|string|min:3|max:190',
            'current_address' => 'required|string|min:3|max:190',
            'confirm_password' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'type' => 'teacher',
                'password' => Hash::make($request->password),
                'publish_status' => $request->publish_status,
                'created_by' => Auth::user()->id,
            ]);
            Teacher::create([
                'user_id' => $user->id,
                'image' => $request->image ?? null,
                'phone' => $request->phone,
                'short_name' => $request->short_name,
                'salary' => $request->salary,
                'subject' => $request->subject,
                'dob' => $request->dob,
                'aadhar_number' => $request->aadhar_number,
                'gender' => $request->gender,
                'current_address' => $request->current_address,
                'permanent_address' => $request->permanent_address,
            ]);
            DB::commit();
            $user->assignRole('Teacher');
            $request->session()->flash('success', 'Teacher added successfully.');
            return redirect()->route('teacher.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $teacher_info = $this->teacher->find($id);
        if (!$teacher_info) {
            abort(404);
        }
        $title = 'Edit User';
        $temp = Subject::where('publish_status', '1')->get();
        $subjects = null;
        foreach ($temp as $value) {
            $subjects[$value->id] = $value->title.' - Level: ' .$value->get_level->standard;
        }
        $data = [
            'title' => $title,
            'teacher_info' => $teacher_info,
            'subjects' => $subjects,
        ];
        return view('admin/teacher/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $teacher_info = $this->teacher->find($id);
        if (!$teacher_info) {
            abort(404);
        }
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
            'email' => 'required|string|min:3|max:190',
            'phone' => 'required|string|min:10|max:10',
            'gender' => 'required|string',
            'level' => 'required',
            'session' => 'required',
            'permanent_address' => 'required|string|min:3|max:190',
            'current_address' => 'required|string|min:3|max:190',
        ]);
        DB::beginTransaction();
        try {
            $user = User::find($teacher_info->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->publish_status = $request->publish_status;
            $user->updated_by = Auth::user()->id;
            $status = $user->save();
            $teacher = teacher::find($teacher_info->id);
            $teacher->phone = $request->phone;
            $teacher->salary = $request->salary;
            $teacher->dob = $request->dob;
            $teacher->aadhar_number = $request->aadhar_number;
            $teacher->gender = $request->gender;
            $teacher->current_address = $request->current_address;
            $teacher->permanent_address = $request->permanent_address;
            if(isset($request->image)){
                $teacher['image'] = $request->image;
            }
            $status = $teacher->save();
            DB::commit();
            $request->session()->flash('success', 'Teacher updated successfully.');
            return redirect()->route('teacher.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }

    }

    public function destroy(Request $request, $id)
    {
        $teacher_info = $this->teacher->find($id);
        if (!$teacher_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $user = User::find($teacher_info->user_id);
            $teacher_info->phone = $teacher_info->phone . '-' . time();
            $user->email = $user->email . '-' . time();
            $user->save();
            $teacher_info->save();
            $teacher_info->delete();
            $user->delete();
            $request->session()->flash('success', 'teacher removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

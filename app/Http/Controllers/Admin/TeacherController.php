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
            $query = $query->where('user_id', $keyword);
        }
        if ($request->filtersubject) {
            $filtersubject = $request->filtersubject;
            $query = $query->whereRaw('json_contains(subject, \'["'.$filtersubject.'"]\')');
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $temp = $this->teacher->get();
        $filter = [];
        foreach ($temp as $key => $value) {
            $filter[$value->user_id] = $value->get_user->name . ' - ' . $value->phone;
        }
        $subjects = Subject::all();
        foreach ($subjects as $key => $value) {
            $filtersubjects[$value->id] = $value->title . ' - ' . $value->get_level->standard.' '.$value->get_level->section;
        }
        $data = $this->getTeacher($request);
        $data = [
            'data' => $data,
            'subjects' => $subjects->pluck('title', 'id'),
            'filter' => $filter,
            'filtersubjects' => $filtersubjects,
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
                'name' =>  htmlentities($request->name),
                'email' => htmlentities($request->email),
                'type' => 'teacher',
                'password' => Hash::make($request->password),
                'publish_status' => htmlentities($request->publish_status),
                'image' => htmlentities($request->image ?? null),
                'phone' => htmlentities($request->phone),
                'short_name' => htmlentities($request->short_name),
                'salary' => htmlentities($request->salary),
                'subject' => ($request->subject),
                'dob' => htmlentities($request->dob),
                'aadhar_number' => htmlentities($request->aadhar_number),
                'gender' => htmlentities($request->gender),
                'current_address' => htmlentities($request->current_address),
                'permanent_address' => htmlentities($request->permanent_address),
                'created_by' => Auth::user()->id,
            ]);
            Teacher::create([
                'user_id' => $user->id,
                'publish_status' => htmlentities($request->publish_status),
                'image' => htmlentities($request->image) ?? null,
                'phone' => htmlentities($request->phone),
                'joining_date' => htmlentities($request->joining_date),
                'short_name' => htmlentities($request->short_name),
                'salary' => htmlentities($request->salary),
                'subject' => $request->subject,
                'dob' => htmlentities($request->dob),
                'aadhar_number' => htmlentities($request->aadhar_number),
                'gender' => htmlentities($request->gender),
                'current_address' => htmlentities($request->current_address),
                'permanent_address' => htmlentities($request->permanent_address),
                'created_by' => Auth::user()->id,
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
        $teacher_info = $this->teacher->find($id);
        if (!$teacher_info) {
            abort(404);
        }
        $title = 'Teacher Detail';
        $subjects = Subject::pluck('title', 'id');
        $data = [
            'title' => $title,
            'teacher_info' => $teacher_info,
            'subjects' => $subjects,
        ];
        return view('admin/teacher/show')->with($data);
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
            $user->name =htmlentities($request->name);
            $user->email =htmlentities($request->email);
            $user->publish_status =htmlentities($request->publish_status);
            $user->updated_by = Auth::user()->id;
            $user->save();
            $teacher = Teacher::find($teacher_info->id);
            $teacher->phone =htmlentities($request->phone);
            $teacher->salary =htmlentities($request->salary);
            $teacher->dob =htmlentities($request->dob);
            $teacher->gender =htmlentities($request->gender);
            $teacher->aadhar_number =htmlentities($request->aadhar_number);
            $teacher->current_address =htmlentities($request->current_address);
            $teacher->permanent_address =htmlentities($request->permanent_address);
            $teacher->updated_by = Auth::user()->id;
            if(isset($request->image)){
                $teacher['image'] =htmlentities($request->image);
            }
            $teacher->save();
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
            $teacher_info->updated_by = Auth::user()->id;
            $user->email = $user->email . '-' . time();
            $user->save();
            $teacher_info->save();
            $teacher_info->delete();
            $user->delete();
            $request->session()->flash('success', 'Teacher removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

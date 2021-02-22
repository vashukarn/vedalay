<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CasteCategory;
use App\Models\Level;
use App\Models\Session;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function __construct(Student $student)
    {
        $this->middleware(['permission:student-list|student-create|student-edit|student-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:student-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:student-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:student-delete'], ['only' => ['destroy']]);
        $this->student = $student;
    }
    protected function getStudent($request)
    {
        $query = $this->student->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getStudent($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/student/list')->with($data);
    }

    public function create()
    {
        $student_info = null;
        $session = Session::pluck('title','title');
        $classes = Level::all();
        foreach ($classes as $value) {
            if(isset($value->section)){
                $levels[$value->id] = $value->standard.' - Section: ' .$value->section;
            }
            else{
                $levels[$value->id] = $value->standard;
            }
        }
        $title = 'Add Student';
        $data = [
            'title' => $title,
            'student_info' => $student_info,
            'session' => $session,
            'levels' => $levels,
        ];
        return view('admin/student/form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
            'email' => 'required|unique:users|string|min:3|max:190',
            'phone' => 'required|string|min:10|max:10',
            'gender' => 'required|string',
            'level' => 'required',
            'session' => 'required',
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
                'type' => 'student',
                'password' => Hash::make($request->password),
                'publish_status' => $request->publish_status,
                'created_by' => Auth::user()->id,
            ]);
            $student = Student::create([
                'user_id' => $user->id,
                'image' => $request->image ?? null,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'level_id' => $request->level,
                'session' => $request->session,
                'aadhar_number' => $request->aadhar_number,
                'blood_group' => $request->blood_group,
                'gender' => $request->gender,
                'caste_category' => $request->caste_category,
                'disability' => $request->disability,
                'fathername' => $request->fathername,
                'fatheroccupation' => $request->fatheroccupation,
                'fatherincome' => $request->fatherincome,
                'mothername' => $request->mothername,
                'motheroccupation' => $request->motheroccupation,
                'motherincome' => $request->motherincome,
                'guardian_name' => $request->guardian_name,
                'guardian_phone' => $request->guardian_phone,
                'current_address' => $request->current_address,
                'permanent_address' => $request->permanent_address,
            ]);
            DB::commit();
            $user->assignRole('Student');
            $request->session()->flash('success', 'Student added successfully.');
            return redirect()->route('student.index');
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
        $student_info = $this->student->find($id);
        if (!$student_info) {
            abort(404);
        }
        $classes = Level::all();
        $session = Session::pluck('title','title');
        foreach ($classes as $value) {
            if(isset($value->section)){
                $levels[$value->id] = $value->standard.' - Section: ' .$value->section;
            }
            else{
                $levels[$value->id] = $value->standard;
            }
        }
        $title = 'Edit User';
        $data = [
            'title' => $title,
            'student_info' => $student_info,
            'session' => $session,
            'levels' => $levels,
        ];
        return view('admin/student/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $student_info = $this->student->find($id);
        if (!$student_info) {
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
            $user = User::find($student_info->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->publish_status = $request->publish_status;
            $user->updated_by = Auth::user()->id;
            $status = $user->save();
            $student = Student::find($student_info->id);
            $student->phone = $request->phone;
            $student->level_id = $request->level;
            $student->session = $request->session;
            $student->dob = $request->dob;
            $student->aadhar_number = $request->aadhar_number;
            $student->blood_group = $request->blood_group;
            $student->gender = $request->gender;
            $student->caste_category = $request->caste_category;
            $student->disability = $request->disability;
            $student->fathername = $request->fathername;
            $student->fatheroccupation = $request->fatheroccupation;
            $student->fatherincome = $request->fatherincome;
            $student->mothername = $request->mothername;
            $student->motheroccupation = $request->motheroccupation;
            $student->motherincome = $request->motherincome;
            $student->guardian_name = $request->guardian_name;
            $student->guardian_phone = $request->guardian_phone;
            $student->current_address = $request->current_address;
            $student->permanent_address = $request->permanent_address;
            if(isset($request->image)){
                $student['image'] = $request->image;
            }
            $status = $student->save();
            DB::commit();
            $request->session()->flash('success', 'Student updated successfully.');
            return redirect()->route('student.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }

    }

    public function destroy(Request $request, $id)
    {
        $student_info = $this->student->find($id);
        if (!$student_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $user = User::find($student_info->user_id);
            $student_info->phone = $student_info->phone . '-' . time();
            $user->email = $user->email . '-' . time();
            $user->save();
            $student_info->save();
            $student_info->delete();
            $user->delete();
            $request->session()->flash('success', 'Student removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}
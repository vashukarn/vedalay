<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
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
            $query = $query->where('user_id', $keyword);
        }
        if ($request->level) {
            $level = $request->level;
            $query = $query->where('level_id', $level);
        }
        if ($request->session) {
            $session = $request->session;
            $query = $query->where('session', $session);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $temp = $this->student->get();
        $filter = [];
        foreach ($temp as $key => $value) {
            $filter[$value->user_id] = $value->get_user->name . ' - ' . $value->phone;
        }
        $data = $this->getStudent($request);
        $classes = Level::all();
        foreach ($classes as $value) {
            if (isset($value->section)) {
                $levels[$value->id] = $value->standard . ' - Section: ' . $value->section;
            } else {
                $levels[$value->id] = $value->standard;
            }
        }
        $temp = Session::all();
        foreach ($temp as $value) {
            $session[$value->id] = $value->start_year . ' - ' . $value->end_year;
        }
        $data = [
            'data' => $data,
            'filter' => $filter,
            'levels' => $levels,
            'session' => $session,
        ];
        return view('admin/student/list')->with($data);
    }
    protected function getAdmission($request)
    {
        $query = Admission::orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('user_id', $keyword);
        }
        return $query->paginate(20);
    }
    public function admission(Request $request)
    {
        $temp = Admission::get();
        $filter = [];
        foreach ($temp as $key => $value) {
            $filter[$value->user_id] = $value->get_user->name . ' - ' . $value->get_student->phone;
        }
        $data = $this->getAdmission($request);
        $data = [
            'data' => $data,
            'filter' => $filter,
        ];
        return view('admin/student/admissionlist')->with($data);
    }

    public function create()
    {
        $student_info = null;
        $temp = Session::all();
        foreach ($temp as $value) {
            $session[$value->id] = $value->start_year . ' - ' . $value->end_year;
        }
        $classes = Level::all();
        foreach ($classes as $value) {
            if (isset($value->section)) {
                $levels[$value->id] = $value->standard . ' - Section: ' . $value->section;
            } else {
                $levels[$value->id] = $value->standard;
            }
        }
        $title = 'Add Student';
        $data = [
            'title' => $title,
            'student_info' => $student_info,
            'admission_info' => null,
            'session' => $session,
            'levels' => $levels,
        ];
        return view('admin/student/form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
            'email' => 'required|unique:users|email|min:3|max:190',
            'phone' => 'required|string|min:10|max:10',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,others',
            'regpriv' => 'required|in:REGULAR,PRIVATE',
            'guardianradio' => 'required|in:Father,Mother,Guardian',
            'level' => 'required|numeric',
            'password' => 'required|required_with:confirm_password|same:confirm_password|min:8|max:190',
            'permanent_address' => 'required|string|min:3|max:190',
            'current_address' => 'required|string|min:3|max:190',
            'confirm_password' => 'required',
            'last_schoolname' => 'required_if:admission,==,on',
            'last_level' => 'required_if:admission,==,on',
            'last_marks' => 'required_if:admission,==,on',
            'last_marksheet' => 'required_if:admission,==,on',
            'transfer_certificate' => 'required_if:admission,==,on',
            'migration_certificate' => 'required_if:admission,==,on',
            'character_certificate' => 'required_if:admission,==,on',
        ]);
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => htmlentities($request->name),
                'email' => htmlentities($request->email),
                'type' => 'student',
                'password' => Hash::make($request->password),
                'publish_status' => htmlentities($request->publish_status),
                'created_by' => Auth::user()->id,
            ]);
            if($request->guardianradio == 'Mother'){
                $guardianname = htmlentities($request->mothername);
            }
            elseif($request->guardianradio == 'Father'){
                $guardianname = htmlentities($request->fathername);
            }
            else{
                $guardianname = htmlentities($request->guardian_name);
            }
            $student = Student::create([
                'user_id' => $user->id,
                'image' => htmlentities($request->image) ?? null,
                'phone' => htmlentities($request->phone),
                'dob' => htmlentities($request->dob),
                'regpriv' => htmlentities($request->regpriv),
                'level_id' => htmlentities($request->level),
                'session' => GETSESSION(),
                'aadhar_number' => htmlentities($request->aadhar_number),
                'blood_group' => htmlentities($request->blood_group),
                'gender' => htmlentities($request->gender),
                'caste_category' => htmlentities($request->caste_category),
                'disability' => htmlentities($request->disability),
                'fathername' => htmlentities($request->fathername),
                'fatheroccupation' => htmlentities($request->fatheroccupation),
                'fatherincome' => htmlentities($request->fatherincome),
                'mothername' => htmlentities($request->mothername),
                'motheroccupation' => htmlentities($request->motheroccupation),
                'motherincome' => htmlentities($request->motherincome),
                'guardian_name' => $guardianname,
                'guardian_phone' => htmlentities($request->guardian_phone),
                'current_address' => htmlentities($request->current_address),
                'permanent_address' => htmlentities($request->permanent_address),
            ]);
            if ($request->admission == 'on') {
                Admission::create([
                    'last_marksheet' => htmlentities($request->last_marksheet),
                    'last_schoolname' => htmlentities($request->last_schoolname),
                    'last_level' => htmlentities($request->last_level),
                    'last_marks' => htmlentities($request->last_marks),
                    'transfer_certificate' => htmlentities($request->transfer_certificate),
                    'character_certificate' => htmlentities($request->character_certificate),
                    'migration_certificate' => htmlentities($request->migration_certificate),
                    'medical_certificate' => htmlentities($request->medical_certificate),
                    'undertaking' => htmlentities($request->undertaking),
                    'last_state' => htmlentities($request->last_state),
                    'last_city' => htmlentities($request->last_city),
                    'user_id' => $user->id,
                    'student_id' => $student->id,
                ]);
            }
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

    public function admissionshow($id)
    {
        $student_info = Admission::find($id);
        if (!$student_info) {
            abort(404);
        }
        $title = 'Admission Student Detail';
        $data = [
            'title' => $title,
            'student_info' => $student_info,
        ];
        return view('admin/student/admissionshow')->with($data);
    }
    public function show($id)
    {
        $user = User::find($id);
        $student_info = $this->student->where('user_id', $user->id)->first();
        if (!$student_info) {
            abort(404);
        }
        $title = 'Student Detail';
        $data = [
            'title' => $title,
            'student_info' => $student_info,
        ];
        return view('admin/student/show')->with($data);
    }

    public function edit($id)
    {
        $student_info = $this->student->find($id);
        if (!$student_info) {
            abort(404);
        }
        $classes = Level::all();
        $temp = Session::all();
        foreach ($temp as $value) {
            $session[$value->id] = $value->start_year . ' - ' . $value->end_year;
        }
        foreach ($classes as $value) {
            if (isset($value->section)) {
                $levels[$value->id] = $value->standard . ' - Section: ' . $value->section;
            } else {
                $levels[$value->id] = $value->standard;
            }
        }
        $title = 'Edit Student';
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
            'permanent_address' => 'required|string|min:3|max:190',
            'current_address' => 'required|string|min:3|max:190',
        ]);
        if($request->guardianradio == 'Mother'){
            $guardianname = htmlentities($request->mothername);
        }
        elseif($request->guardianradio == 'Father'){
            $guardianname = htmlentities($request->fathername);
        }
        else{
            $guardianname = htmlentities($request->guardian_name);
        }
        DB::beginTransaction();
        try {
            $user = User::find($student_info->user_id);
            $user->name = htmlentities($request->name);
            $user->email = htmlentities($request->email);
            $user->publish_status = htmlentities($request->publish_status);
            $user->updated_by = Auth::user()->id;
            $user->save();
            $student = Student::find($student_info->id);
            $student->phone = htmlentities($request->phone);
            $student->level_id = htmlentities($request->level);
            $student->session = htmlentities($request->session);
            $student->dob = htmlentities($request->dob);
            $student->aadhar_number = htmlentities($request->aadhar_number);
            $student->blood_group = htmlentities($request->blood_group);
            $student->gender = htmlentities($request->gender);
            $student->caste_category = htmlentities($request->caste_category);
            $student->disability = htmlentities($request->disability);
            $student->fathername = htmlentities($request->fathername);
            $student->fatheroccupation = htmlentities($request->fatheroccupation);
            $student->fatherincome = htmlentities($request->fatherincome);
            $student->mothername = htmlentities($request->mothername);
            $student->motheroccupation = htmlentities($request->motheroccupation);
            $student->motherincome = htmlentities($request->motherincome);
            $student->guardian_name = htmlentities($guardianname);
            $student->guardian_phone = htmlentities($request->guardian_phone);
            $student->current_address = htmlentities($request->current_address);
            $student->permanent_address = htmlentities($request->permanent_address);
            $student->updated_by = Auth::user()->id;
            if (isset($request->image)) {
                $student->image = htmlentities($request->image);
            }
            $student->save();
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
            $student_info->updated_by = Auth::user()->id;
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

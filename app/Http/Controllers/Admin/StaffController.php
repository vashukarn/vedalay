<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function __construct(Staff $staff)
    {
        $this->middleware(['permission:staff-list|staff-create|staff-edit|staff-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:staff-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:staff-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:staff-delete'], ['only' => ['destroy']]);
        $this->staff = $staff;
    }
    protected function getStaff($request)
    {
        $query = $this->staff->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('user_id', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $temp = $this->staff->get();
        $filter = [];
        foreach ($temp as $key => $value) {
            $filter[$value->user_id] = $value->get_user->name . ' - ' . $value->phone;
        }
        $data = $this->getStaff($request);
        $data = [
            'data' => $data,
            'filter' => $filter,
        ];
        return view('admin/staff/list')->with($data);
    }

    public function create()
    {
        $staff_info = null;
        $title = 'Add Staff';
        $data = [
            'title' => $title,
            'staff_info' => $staff_info,
        ];
        return view('admin/staff/form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
            'email' => 'required|unique:users|string|min:3|max:190',
            'phone' => 'required|string|min:10|max:10',
            'gender' => 'required',
            'position' => 'required',
            'password' => 'required|required_with:confirm_password|same:confirm_password|min:8|max:190',
            'permanent_address' => 'required|string|min:3|max:190',
            'current_address' => 'required|string|min:3|max:190',
            'confirm_password' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => htmlentities($request->name),
                'email' => htmlentities($request->email),
                'type' => 'staff',
                'password' => Hash::make(htmlentities($request->password)),
                'publish_status' => htmlentities($request->publish_status),
                'created_by' => Auth::user()->id,
            ]);
            Staff::create([
                'user_id' => $user->id,
                'image' => htmlentities($request->image),
                'phone' => htmlentities($request->phone),
                'dob' => htmlentities($request->dob),
                'position' => htmlentities($request->position),
                'joining_date' => htmlentities($request->joining_date),
                'salary' => htmlentities($request->salary),
                'aadhar_number' => htmlentities($request->aadhar_number),
                'gender' => htmlentities($request->gender),
                'current_address' => htmlentities($request->current_address),
                'permanent_address' => htmlentities($request->permanent_address),
            ]);
            DB::commit();
            $user->assignRole('Staff');
            $request->session()->flash('success', 'Staff added successfully.');
            return redirect()->route('staff.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $staff_info = $this->staff->find($id);
        if (!$staff_info) {
            abort(404);
        }
        $title = 'Staff Detail';
        $data = [
            'title' => $title,
            'staff_info' => $staff_info,
        ];
        return view('admin/staff/show')->with($data);
    }

    public function edit($id)
    {
        $staff_info = $this->staff->find($id);
        if (!$staff_info) {
            abort(404);
        }
        $title = 'Edit User';
        $data = [
            'title' => $title,
            'staff_info' => $staff_info,
        ];
        return view('admin/staff/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $staff_info = $this->staff->find($id);
        if (!$staff_info) {
            abort(404);
        }
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
            'phone' => 'required|string|min:10|max:10',
            'gender' => 'required',
            'position' => 'required',
            'permanent_address' => 'required|string|min:3|max:190',
            'current_address' => 'required|string|min:3|max:190',
        ]);
        DB::beginTransaction();
        try {
            $user = User::find($staff_info->user_id);
            $user->name = htmlentities($request->name);
            $user->publish_status = htmlentities($request->publish_status);
            $user->updated_by = Auth::user()->id;
            $user->save();
            $staff = Staff::find($staff_info->id);
            $staff->phone = htmlentities($request->phone);
            $staff->salary = htmlentities($request->salary);
            $staff->dob = htmlentities($request->dob);
            $staff->position = htmlentities($request->position);
            $staff->aadhar_number = htmlentities($request->aadhar_number);
            $staff->gender = htmlentities($request->gender);
            $staff->current_address = htmlentities($request->current_address);
            $staff->permanent_address = htmlentities($request->permanent_address);
            if(isset($request->image)){
                $staff['image'] = htmlentities($request->image);
            }
            $staff->save();
            DB::commit();
            $request->session()->flash('success', 'Staff updated successfully.');
            return redirect()->route('staff.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }

    }

    public function destroy(Request $request, $id)
    {
        $staff_info = $this->staff->find($id);
        if (!$staff_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $user = User::find($staff_info->user_id);
            $staff_info->phone = $staff_info->phone . '-' . time();
            $user->updated_by = Auth::user()->id;
            $user->email = $user->email . '-' . time();
            $user->save();
            $staff_info->save();
            $staff_info->delete();
            $user->delete();
            $request->session()->flash('success', 'Staff removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

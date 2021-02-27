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
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getStaff($request);
        $data = [
            'data' => $data,
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
                'name' => $request->name,
                'email' => $request->email,
                'type' => 'staff',
                'password' => Hash::make($request->password),
                'publish_status' => $request->publish_status,
                'created_by' => Auth::user()->id,
            ]);
            Staff::create([
                'user_id' => $user->id,
                'image' => $request->image ?? null,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'position' => $request->position,
                'salary' => $request->salary,
                'aadhar_number' => $request->aadhar_number,
                'gender' => $request->gender,
                'current_address' => $request->current_address,
                'permanent_address' => $request->permanent_address,
                'created_by' => Auth::user()->id,
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
        //
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
            'email' => 'required|string|min:3|max:190',
            'phone' => 'required|string|min:10|max:10',
            'gender' => 'required',
            'position' => 'required',
            'permanent_address' => 'required|string|min:3|max:190',
            'current_address' => 'required|string|min:3|max:190',
        ]);
        DB::beginTransaction();
        try {
            $user = User::find($staff_info->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->publish_status = $request->publish_status;
            $user->updated_by = Auth::user()->id;
            $user->save();
            $staff = Staff::find($staff_info->id);
            $staff->phone = $request->phone;
            $staff->salary = $request->salary;
            $staff->dob = $request->dob;
            $staff->position = $request->position;
            $staff->aadhar_number = $request->aadhar_number;
            $staff->gender = $request->gender;
            $staff->current_address = $request->current_address;
            $staff->permanent_address = $request->permanent_address;
            $staff->updated_by = Auth::user()->id;
            if(isset($request->image)){
                $staff['image'] = $request->image;
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
            $staff_info->updated_by = Auth::user()->id;
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

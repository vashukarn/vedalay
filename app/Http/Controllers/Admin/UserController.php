<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Student;
use App\Models\Task;
use App\Models\Teacher;
use App\Utilities\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;
    public function __construct(User $user)
    {
        /* 'role:Super Admin', */
        $this->middleware(['role:Super Admin', 'permission:user-list|user-create|user-edit|user-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['role:Super Admin', 'permission:user-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role:Super Admin', 'permission:user-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role:Super Admin', 'permission:user-delete'], ['only' => ['destroy']]);
        $this->user = $user;
    }
    public function index()
    {

        $this->user = $this->user->where('type', 'admin')->orderBy('id', 'ASC')->paginate();
        return view('admin.users.user-list')->with('data', $this->user);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name');
        return view('admin.users.user-form', compact('roles'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = $this->user->getRules();
            $request->validate($rules);
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            $data['type'] = 'admin';
            $this->user->fill($data);
            $status = $this->user->save();
            DB::commit();
            if ($status) {
                $this->user->assignRole($request->input('roles'));
                $request->session()->flash('success', "User Created Successfully");
            } else {
                $request->session()->flash('error', "Sorry! Error While Adding the new user");
            }
            return redirect()->route('users.index');
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
        $this->user = $this->user->find($id);
        if (!$this->user) {
            request()->session()->flash('error', 'Error ! User Not Found');
            return redirect()->back();
        }
        $roles = Role::pluck('name', 'name');
        $userRole = $this->user->roles->pluck('name', 'name')->all();
        return view('admin.users.user-form', compact('roles', 'userRole'))->with('user_detail', $this->user);
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->user = $this->user->find($id);
            if (!$this->user) {
                request()->session()->flash('error', 'Error ! User Not Found');
                return redirect()->back();
            }
            $rules = $this->user->getRules('update', $id);
            $request->validate($rules);
            $data = $request->all();
            if (isset($request->change_password)) {
                $data['password'] = Hash::make($request->password);
            } else {
                $data['password'] = $this->user->password;  //if password comes blank set old password
            }
            $this->user->fill($data);
            $status = $this->user->save();
            if ($status) {
                DB::table('model_has_roles')->where('model_id', $id)->delete();
                $this->user->assignRole($request->input('roles'));
                $request->session()->flash('success', "User Updated Successfully");
            } else {
                $request->session()->flash('error', "Sorry! Error While Updating the user");
            }
            DB::commit();
            return redirect()->route('users.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $this->user = $this->user->find($id);
        if (!$this->user || $this->user->id == request()->user()->id) {
            request()->session()->flash('error', 'Eror ! You Can Not Delete Your Self');
            return redirect()->back();
        }
        $status = $this->user->delete();
        if ($status) {
            request()->session()->flash('success', "User Deleted Successfully");
        } else {
            request()->session()->flash('error', "Sorry! Error While Deleting the new user");
        }
        return redirect()->route('users.index');
    }

    public function profiledetail()
    {
        $user_info = Auth::user();
        if (Auth::user()->type == 'student') {
            $student_info = Student::where('user_id', Auth::user()->id)->first();
            $classes = Level::all();
            foreach ($classes as $value) {
                if (isset($value->section)) {
                    $levels[$value->id] = $value->standard . ' - Section: ' . $value->section;
                } else {
                    $levels[$value->id] = $value->standard;
                }
            }
        }
        if (Auth::user()->type == 'teacher') {
            $teacher_info = Teacher::where('user_id', Auth::user()->id)->first();
        }
        $tasks = Task::where('created_by', $user_info->id)->orderBy('deadline', 'ASC')->paginate(5);
        $data = [
            'user_info' => $user_info,
            'student_info' => $student_info ?? null,
            'tasks' => $tasks,
            'teacher_info' => $teacher_info ?? null,
            'levels' => $levels ?? null,
        ];
        return view('admin.auth.profile')->with($data);
    }

    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'current_password' => 'required',
            'password_confirmation' => 'required',
            'password' => 'required|string|min:6|confirmed|different:current_password',
        ]);
        $this->user = $this->user->find($id);
        if (!$this->user) {
            $request->session()->flash('error', 'User not found');
            return redirect(route('users.index'));
        }
        $data = $request->all();
        if (!Hash::check($data['current_password'], auth()->user()->password)) {
            return back()->with('warning', 'Current Password Not Matched.');
        } else {
            $data['password'] = Hash::make($request->password);
            $this->user->fill($data);
            $status = $this->user->save();
            if ($status) {
                LogActivity::addToLog("Password Changed Successfully");
                $request->session()->flash('success', 'Password Updated Successfully');
            } else {
                $request->session()->flash('error', 'Sorry! Error While Updating the Password');
            }
            Auth::logout();
            return redirect()->route('dashboard.index');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }

    public function recovery()
    {
        return view('admin.auth.two-factor-recovery');
    }
    public function ban($id)
    {
        User::where('id', $id)->update(['status' => '2']);
        return redirect()->back();
    }
    public function unban($id)
    {
        User::where('id', $id)->update(['status' => '1']);
        return redirect()->back();
    }
}

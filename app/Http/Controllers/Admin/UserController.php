<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Utilities\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;
    public function __construct(User $user)
    {
        /* 'role:Super Admin', */
        $this->middleware(['role:Super Admin','permission:user-list|user-create|user-edit|user-delete'], ['only' => ['index','store']]);
        $this->middleware(['role:Super Admin','permission:user-create'], ['only' => ['create','store']]);
        $this->middleware(['role:Super Admin','permission:user-edit'], ['only' => ['edit','update']]);
        $this->middleware(['role:Super Admin','permission:user-delete'], ['only' => ['destroy']]);
        $this->user=$user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->user = $this->user->where('type','admin')->orderBy('id', 'ASC')->paginate();
        return view('admin.users.user-list')->with('data',$this->user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('admin.users.user-form',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=$this->user->getRules();
        $request->validate($rules);
        $data=$request->all();
        // dd($data);
        $data['password']=Hash::make($request->password);
        $data['type']='admin';
        $this->user->fill($data);
        $status=$this->user->save();
        if($status){
            $this->user->assignRole($request->input('roles'));
            //$this->user->sendEmailVerificationNotification();
            $request->session()->flash('success',"User Created Successfully");
        }else{
            $request->session()->flash('error',"Sorry! Error While Adding the new user");
        }
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->user=$this->user->find($id);
        if(!$this->user){
            request()->session()->flash('error','Error ! User Not Found');
            return redirect()->back();
        }
        $roles = Role::pluck('name','name')->all();
        $userRole = $this->user->roles->pluck('name','name')->all();
        return view('admin.users.user-form',compact('roles','userRole'))->with('user_detail',$this->user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->user=$this->user->find($id);
        if(!$this->user){
            request()->session()->flash('error','Eror ! User Not Found');
            return redirect()->back();
        }
        $rules=$this->user->getRules('update',$id);
        $request->validate($rules);
        $data=$request->all();
        if(isset($request->change_password)){
            $data['password']=Hash::make($request->password);
        }else{
            $data['password']=$this->user->password;  //if password comes blank set old password
        }
        $this->user->fill($data);
        $status=$this->user->save();
        if($status){
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $this->user->assignRole($request->input('roles'));
            $request->session()->flash('success',"User Updated Successfully");
        }else{
            $request->session()->flash('error',"Sorry! Error While Updating the user");
        }
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user=$this->user->find($id);
        if(!$this->user || $this->user->id == request()->user()->id){
            request()->session()->flash('error','Eror ! You Can Not Delete Your Self');
            return redirect()->back();
        }
        $status=$this->user->delete();
        if($status){
            request()->session()->flash('success',"User Deleted Successfully");
        }else{
            request()->session()->flash('error',"Sorry! Error While Deleting the new user");
        }
        return redirect()->route('users.index');
    }

    /**
     * update profile
     *
     * @return void
     */
    public function profiledetail()
    {
        return view('admin.auth.profile');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */

    public function updatePassword(Request $request, $id){
        $this->validate($request, [
            'name'=>'required|string|max:50',
            'current_password'=>'required',
            'password_confirmation'=>'required',
            'password'=>'required|string|min:8|confirmed|different:current_password|regex:'. $this->user->regex()
        ]);
        $this->user = $this->user->find($id);
        if (!$this->user) {
            $request->session()->flash('error', 'User not found');
            return redirect(route('users.index'));
        }
        $data = $request->all();
        if(!Hash::check($data['current_password'], auth()->user()->password)){
            return back()->with('warning','Current Password Not Matched.');
        }else{
            $data['password']=Hash::make($request->password);
            $this->user->fill($data);
            $status=$this->user->save();
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

    /**
     *  logout user
     * @param Request $request
     * @return void
     */

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }

    /**
     * 2FA Recovery function
     *
     * @return void
     */

    public function recovery(){
        return view('admin.auth.two-factor-recovery');
    }
    public function ban($id)
    {
        User::where('id', $id)->update(['status'=> '2']);
        return redirect()->back();
    }
    public function unban($id)
    {
        User::where('id', $id)->update(['status'=> '1']);
        return redirect()->back();
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    public function __construct(Profile $profile)
    {
        $this->middleware(['permission:profile-list|profile-create|profile-edit|profile-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:profile-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:profile-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:profile-delete'], ['only' => ['destroy']]);
        $this->profile = $profile;
    }
    protected function getProfile($request)
    {
        $query = $this->profile->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getProfile($request);
        $roles = Role::pluck('name', 'name')->all();
        $data = [
            'data' => $data,
            'roles' => $roles,
        ];
        return view('admin/profile/list')->with($data);
    }

    public function create()
    {
        $profile_info = null;
        $title = 'Add User';
        $roles = Role::pluck('name', 'name')->all();
        $data = [
            'title' => $title,
            'profile_info' => $profile_info,
            'roles' => $roles,
        ];
        return view('admin/profile/form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
            'email' => 'required|unique:users|string|min:3|max:190',
            'phone' => 'required|unique:profiles|string|min:3|max:190',
            'password' => 'required|required_with:confirm_password|same:confirm_password|min:8|max:190',
            'address' => 'required|string|min:3|max:190',
            'confirm_password' => 'required',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'publish_status' => $request->publish_status,
                'created_by' => Auth::user()->id,
            ]);
            moveImage($request->image_name, profileimagepath);
            $profile = Profile::create([
                'user_id' => $user->id,
                'image' => $request->image_name ?? null,
                'phone' => $request->phone,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'address' => $request->address,
                'slug_url' => Str::slug($request->name),
            ]);
            DB::commit();
            $user->assignRole($request->input('roles'));
            $request->session()->flash('success', 'Profile created successfully.');
            return redirect()->route('profile.index');
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
        $profile_info = $this->profile->find($id);
        if (!$profile_info) {
            abort(404);
        }
        $title = 'Edit User';
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $profile_info->get_user->roles->pluck('name', 'name')->all();
        $data = [
            'title' => $title,
            'profile_info' => $profile_info,
            'roles' => $roles,
            'userRole' => $userRole,
        ];
        return view('admin/profile/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $profile_info = $this->profile->find($id);
        if (!$profile_info) {
            abort(404);
        }
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
            'email' => 'required|string|min:3|max:190',
            'phone' => 'required|string|min:3|max:190',
            'address' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        DB::beginTransaction();
        try {
            $profile_info->phone = htmlentities($request->phone);
            $profile_info->address = htmlentities($request->address);
            $profile_info->facebook = htmlentities($request->facebook);
            $profile_info->twitter = htmlentities($request->twitter);
            $profile_info->image = htmlentities($request->image_name) ?? null;
            $profile_info->get_user->name = htmlentities($request->name);
            $profile_info->get_user->email = htmlentities($request->email);
            $profile_info->save();
            $user_data = User::find($profile_info->user_id);
            $user_data->name = htmlentities($request->name);
            $user_data->email = htmlentities($request->email);
            $user_data->publish_status = htmlentities($request->publish_status);
            $user_data->updated_by = Auth::user()->id;
            $user_data->save();
            $user_data->assignRole($request->input('roles'));
            moveImage($request->image_name, profileimagepath);
            if ($profile_info) {
                $oldImage =  $profile_info->image;
                if ($request->image_name != $oldImage) {
                    removeImage($oldImage, profileimagepath);
                }
            }
            DB::commit();
            $request->session()->flash('success', 'Profile created successfully.');
            return redirect()->route('profile.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $profile_info = $this->profile->find($id);
        if (!$profile_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $user = User::find($profile_info->user_id);
            $profile_info->phone = $profile_info->phone . '-' . time();
            $user->email = $user->email . '-' . time();
            $user->save();
            $profile_info->save();

            $profile_info->delete();
            $user->delete();
            $request->session()->flash('success', 'User removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

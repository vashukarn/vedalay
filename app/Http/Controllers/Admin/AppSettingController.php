<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\SmsSetting;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    protected $appSetting;
    protected $smsSetting;
    public function __construct(AppSetting $appSetting, SmsSetting $smsSetting)
    {
        $this->middleware(['role:Super Admin']);
        $this->appSetting = $appSetting;
        $this->smsSetting = $smsSetting;
    }
    public function index()
    {
        if ($this->appSetting) {
            $this->appSetting = $this->appSetting->orderBy('created_at', 'desc')->first();
        } else {
            $this->appSetting = [];
        }
        return view('admin.setting.app-setting')->with('site_detail', $this->appSetting);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
        ]);
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->contact_no,
            'logo' => $request->logo ?? null,
            'logo_light' => $request->logo_light ?? null,
            'favicon' => $request->favicon ?? null,
            'og_image' => $request->og_image ?? null,
            'is_favicon' => $request->is_favicon,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'skype' => $request->skype,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'meta' => $request->meta,
            'is_meta' => $request->is_meta,
        ];
        try {
            $this->appSetting->fill($data)->save();
            $request->session()->flash('success', 'Settings saved successfully.');
            return redirect()->route('setting.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $appSetting = $this->appSetting->find($id);
        if (!$appSetting) {
            abort(404);
        }
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->contact_no,
            'is_favicon' => $request->is_favicon,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'skype' => $request->skype,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'meta' => $request->meta,
            'is_meta' => $request->is_meta,
        ];
        if($request->logo){
            $data['logo'] = $request->logo;
        }
        if($request->logo_light){
            $data['logo_light'] = $request->logo_light;
        }
        if($request->og_image){
            $data['og_image'] = $request->og_image;
        }
        if($request->favicon){
            $data['favicon'] = $request->favicon;
        }

        try {
            $appSetting->fill($data)->save();
            $request->session()->flash('success', 'Settings updated successfully.');
            return redirect()->route('setting.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}

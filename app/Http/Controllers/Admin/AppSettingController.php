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
        dd($request->all());
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
        ]);
        // dd($request->all());

        // "front_feature_description" => null
        // "front_counter_description" => null
        // "front_testimonial_description" => null
        // "is_meta" => "NO"
        // "meta_title" => null
        // "meta_key" => null
        // "meta_desc" => null
        // "logo"
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_favicon' => $request->is_favicon,
            'twitter' => $request->twitter,
            'app_url' => $request->driver_app_url,
            'vat' => $request->vat,
            'vat_status' => $request->vat_status,
            'vat_discount_status' => $request->vat_discount_status,
            'customer_app_url' => $request->customer_app_url,
            'driver_app_image' => $request->driver_app_image,
            'customer_app_image' => $request->customer_app_image,
            'front_feature_description' => $request->front_feature_description,
            'front_counter_description' => $request->front_counter_description,
            'front_testimonial_description' => $request->front_testimonial_description,
            'commission' => $request->commission,
            'facebook' => $request->facebook,
            'youtube' => $request->youtube,

            'is_meta' => $request->is_meta,
            'meta_title' => $request->meta_title,
            'meta_key' => $request->meta_key,
            'meta_desc' => $request->meta_desc,
        ];
        if ($request->logo) {
            $logo_name = uploadFile($request->logo, 'uploads/settings/', false, time());
            if ($logo_name) {
                $data['logo'] = $logo_name;
            }
        }
        if ($request->favicon) {
            $favicon_name = uploadFile($request->favicon, 'uploads/settings/', false, time());
            if ($favicon_name) {
                $data['favicon'] = $favicon_name;
            }
        }
        if ($request->og_image) {
            $og_image_name = uploadFile($request->og_image, 'uploads/settings/', false, time());
            if ($og_image_name) {
                $data['og_image'] = $og_image_name;
            }
        }
        if ($request->driver_app_image) {
            $driver_app_image_name = uploadFile($request->driver_app_image, 'uploads/settings/', false, time());
            if ($driver_app_image_name) {
                $data['driver_app_image'] = $driver_app_image_name;
            }
        }
        if ($request->customer_app_image) {
            $customer_app_image_name = uploadFile($request->customer_app_image, 'uploads/settings/', false, time());
            if ($customer_app_image_name) {
                $data['customer_app_image'] = $customer_app_image_name;
            }
        }
        try {
            $this->appSetting->fill($data)->save();
            $request->session()->flash('success', 'Settings saved successfully.');
            return redirect()->route('setting.index');
        } catch (\Exception $error) {
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
        //
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $appSetting = $this->appSetting->find($id);
        if (!$appSetting) {
            abort(404);
        }
        // dd($appSetting);
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
            'address' => 'required|string|min:3|max:190',
            'email' => 'required|email|min:3|max:190',
            // 'phone' => 'required|digits:10',
            "contact_no.*.phone_number" => 'nullable|digits:10',
            "contact_no.*.contact_city" => 'nullable|string|max:100',
            'commission' => 'required|numeric',
        ]);
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_favicon' => $request->is_favicon,
            'twitter' => $request->twitter,
            'driver_app_url' => $request->driver_app_url,
            'customer_app_url' => $request->customer_app_url,
            'facebook' => $request->facebook,
            'youtube' => $request->youtube,
            'commission' => $request->commission,
            'otp_expire' => $request->otp_expire,
            'vat' => $request->vat,
            'vat_status' => $request->vat_status,
            'vat_discount_status' => $request->vat_discount_status,
            'from_time' => $request->from_time,
            'to_time' => $request->to_time,
            'is_meta' => $request->is_meta,
            'meta_title' => $request->meta_title,
            'meta_key' => $request->meta_key,
            'meta_desc' => $request->meta_desc,
            'front_feature_description' => $request->front_feature_description,
            'front_counter_description' => $request->front_counter_description,
            'front_testimonial_description' => $request->front_testimonial_description,
        ];
        // dd($request->contact_no);
        $data['contact_no'] = $request->contact_no;
        if ($request->logo) {
            $logo_name = uploadFile($request->logo, 'uploads/settings/', false, time());
            if ($logo_name) {
                $data['logo'] = $logo_name;
            }
        }
        if ($request->favicon) {
            $favicon_name = uploadFile($request->favicon, 'uploads/settings/', false, time());
            if ($favicon_name) {
                $data['favicon'] = $favicon_name;
            }
        }
        if ($request->og_image) {
            $og_image_name = uploadFile($request->og_image, 'uploads/settings/', false, time());
            if ($og_image_name) {
                $data['og_image'] = $og_image_name;
            }
        }
        if ($request->driver_app_image) {
            $driver_app_image_name = uploadFile($request->driver_app_image, 'uploads/settings/', false, time());
            if ($driver_app_image_name) {
                $data['driver_app_image'] = $driver_app_image_name;
            }
        }
        if ($request->customer_app_image) {
            $customer_app_image_name = uploadFile($request->customer_app_image, 'uploads/settings/', false, time());
            if ($customer_app_image_name) {
                $data['customer_app_image'] = $customer_app_image_name;
            }
        }

        try {
            $appSetting->fill($data)->save();
            $request->session()->flash('success', 'Settings saved successfully.');
            return redirect()->route('setting.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        //
    }

    public function smsApi()
    {
        $this->smsSetting = $this->smsSetting->orderBy('created_at', 'desc')->first();
        return view('admin.setting.sms-setting')->with('api_detail', $this->smsSetting);
    }

    public function smsApiSave(Request $request)
    {
        //dd($request->all());
        $rule = $this->smsSetting->getRules();
        $request->validate($rule);
        $data = $request->all();
        $this->smsSetting->fill($data);
        $status = $this->smsSetting->save();
        if (!empty($status)) {
            $request->session()->flash('success', 'SMS API Updated Successfully');
        } else {
            $request->session()->flash('error', 'Sorry ! SMS API Setting Could not updated');
        }
        return redirect(route('smsApi.index'));
    }

    public function smsApiUpdate(Request $request, $id)
    {
        $rule = $this->smsSetting->getRules();
        $request->validate($rule);
        $this->smsSetting = $this->smsSetting->find($id);
        if (!$this->smsSetting) {
            $request->session()->flash('error', 'SMS Setting not found');
            return redirect(route('websms.index'));
        }
        if ($request->status == 0) {
            $data = $request->only('status');
        } else {
            $data = $request->all();
        }
        $this->smsSetting->fill($data);
        $status = $this->smsSetting->save();
        if (!empty($status)) {
            $request->session()->flash('success', 'SMS API Updated Successfully');
        } else {
            $request->session()->flash('error', 'Sorry ! SMS API Setting Could not updated');
        }
        return redirect(route('smsApi.index'));
    }

}

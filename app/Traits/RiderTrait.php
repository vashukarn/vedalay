<?php

namespace App\Traits;

use Illuminate\Support\Facades\Hash;

/**
 *
 */
trait RiderTrait
{

    public function getRules($request, $act = 'add', $id = null)
    {
        $rules = [
            'name' => 'required|string|max:50',
            'email' => 'required|unique:users,email', //email:rfc,dns|
            'mobile' => 'required|digits:10|numeric|unique:users,mobile',
            'password' => 'nullable|string|min:8|confirmed|',
            // 'password' => 'nullable|string|min:8|confirmed|regex:' . $this->regex(),
            'status' => 'required|in:1,0',
            // 'roles' => 'required',
            // "pan_number" => "required|string|min:6",
            "license_number" => "required|string|min:1",
            "registration_number" => "required|string|min:1",
            "refer_code" => "nullable|string|min:4",
            // "reference_number" => "nullable|string|min:4",
            "model" => "nullable|string|min:1",
            "year" => "nullable|date_format:Y",
            // "vehicle_lot_no" => "nullable|string|min:3|max:20",
            "vehicle_brand" => "nullable|string|min:1|max:20",
            "vehicle_type" => "required|numeric|exists:vehicle_types,id",

            "owners_name" => "required|string|min:1|max:20",
            "owners_contact_no" => "required|string|min:1|max:15",
            "owners_email_address" => "nullable|email",
            "owners_address" => "required|string|min:1|max:100",
        ];
        // if($request->)

        if ($act == 'update') {
            // $rules['password'] = 'nullable|string|min:8|confirmed|regex:' . $this->regex();
            $rules['pan_number'] = 'nullable|string|min:1';
            $rules['email'] = 'nullable|email';
            $rules['mobile'] = 'nullable|digits:10|numeric|unique:users,mobile,' . $id;
        } else {
            $rules['password'] = 'required|string|min:8|confirmed|';
            $rules['pan_number'] = 'required|string|min:1';
        }
        return $rules;
    }
    protected function mapRiderData($request, $rider, $riderDetail = null)
    {
        $data = [

            "address" => $request->address,
            "districtId" => $request->districtId,
            "gender" => $request->gender,
            "date_of_birth" => $request->date_of_birth,
            "refer_code" => $request->refer_code,
            "is_verified" => $request->is_verified,
            // "created_by" => $request->user->id,
            "user_id" => $rider->id,
            "vehicle_info" => $this->mapVehicleData($request, $riderDetail),
            "documents" => $this->mapDocument($request, $rider->mobile, $riderDetail),
            "owner_detail" => $this->mapVehicleOwner($request, $riderDetail),
            // ""
        ];
        // dd($request->date_of_birth_np);
        if($request->date_of_birth_np){
            $data['date_of_birth'] = dateeng($request->date_of_birth_np);
            $data['date_of_birth_np'] =  $request->date_of_birth_np;
        }else if ($request->date_of_birth){
            $data['date_of_birth'] = $request->date_of_birth;
            $data['date_of_birth_np'] =datenep( $request->date_of_birth);
            // dateeng($request->date_of_birth);
        }
        // dd($data);
        return $data;
    }
    protected function mapVehicleData($request, $riderDetail = null)
    {
        if ($riderDetail) {
            $data = @$riderDetail->vehicle_info;
        }
        if ($request->model)
            $data['model'] = $request->model;
        if ($request->year)
            $data['year'] = $request->year;
        if ($request->vehicle_type)
            $data['vehicle_type'] = $request->vehicle_type;
        // if ($request->vehicle_lot_no)
        //     $data['vehicle_lot_no'] = $request->vehicle_lot_no;
        if ($request->vehicle_brand)
            $data['vehicle_brand'] = $request->vehicle_brand;
        // if ($request->license_number)
        // $data['license_number'] = $request->license_number;
        if ($request->registration_number)
            $data['registration_number'] = $request->registration_number;
        if ($request->pan_number)
            $data['pan_number'] = $request->pan_number;
        return $data;
    }



    protected function mapDocument($request, $mobile,  $riderDetail)
    {
        // dd($request->all());
        $data  = $riderDetail ? $riderDetail->documents : [];
        if ($request->citizenship_no) {
            $data['citizenship_no'] = $request->citizenship_no;
        }
        if ($request->license_number) {
            $data['license_number'] = $request->license_number;
        }
        if ($request->national_id_card_no) {
            $data['national_id_card_no'] = $request->national_id_card_no;
        }
        if ($request->expiry_date) {
            $data['expiry_date'] = $request->expiry_date;
        }
        // if ($request->license_no) {
        //     $data['license_no'] = $request->license_no;
        // }
        // license_no expiry_date, 

        // $data['national_id_card_no'] = $request->national_id_card_no;

        if ($request->citizenship) {
            // dd($request->citizenship);
            if ($request->citizenship) {
                $citizenship = uploadFile($request->citizenship, 'uploads/riders/', false, $mobile);
                if ($citizenship) {
                    $data['citizenship'] = $citizenship;
                    deleteFile(@$riderDetail->documents['citizenship'], 'uploads/riders', false);
                }
            }
        }
        if ($request->billbook) {
            $billbook = uploadFile($request->billbook, 'uploads/riders/', false, $mobile);
            if ($billbook) {
                $data['billbook'] = $billbook;
                deleteFile(@$riderDetail->documents['billbook'], 'uploads/riders', false);
            }
        }
        if ($request->license) {
            $license = uploadFile($request->license, 'uploads/riders/', false, $mobile);
            if ($license) {
                $data['license'] = $license;
                deleteFile(@$riderDetail->documents['license'], 'uploads/riders', false);
            }
        }

        if ($request->national_id_card) {
            $national_id_card = uploadFile($request->national_id_card, 'uploads/riders/', false, $mobile);
            if ($national_id_card) {
                $data['national_id_card'] = $national_id_card;
                deleteFile(@$riderDetail->documents['national_id_card'], 'uploads/riders', false);
            }
        }

        return $data;
    }
    protected function mapVehicleOwner($request, $riderDetail)
    {
        if ($riderDetail) {
            $data = @$riderDetail->owner_detail;
            if ($request->owners_name) {
                $data['owners_name'] = $request->owners_name;
            }

            if ($request->owners_contact_no) {
                $data['owners_contact_no'] = $request->owners_contact_no;
            }

            if ($request->owners_email_address) {
                $data['owners_email_address'] = $request->owners_email_address;
            }

            if ($request->owners_address) {
                $data['owners_address'] = $request->owners_address;
            }
        } else {
            $data = [
                "owners_name" => $request->owners_name,
                "owners_contact_no" => $request->owners_contact_no,
                "owners_email_address" => $request->owners_email_address,
                "owners_address" => $request->owners_address,
            ];
        }
        return $data;
    }

    protected function mapUserData($request, $user_type = null, $userInfo = null)
    {
        if (!$user_type) {
            $user_type = 'rider';
        }
        $data = [
            "name" => $request->name,
            // "email"         => $request->email,
            // "password"      => $request->password,
            "status" => $request->status,
            "type" => $user_type,
            // "mobile" => ($request->mobile) ??
        ];
        if ($request->mobile) {
            $data['mobile'] = $request->mobile;
        }

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->email) {
            $data['email'] = $request->email;
        }
        return $data;
    }

    public function regex()
    {
        return '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';
    }
}

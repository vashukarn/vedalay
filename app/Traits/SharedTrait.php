<?php

namespace App\Traits;

use App\Models\AppSetting;
use App\Models\City;
use App\Models\District;
use App\Models\Notification;
use App\Models\Province;
use App\Models\Rider;
use App\Models\RidingCost;
use App\Models\RidingRequest;
use App\Models\VehicleType;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Validator;

trait SharedTrait
{


    public function getVehicleTypes(Request $request)
    {
        // dd($request->all());
        cache()->forget('api_vehicle_type');
        $vehicle_types = cache()->remember('api_vehicle_type', 60 * 60 * 4, function () {
            return VehicleType::where('status', 'active')->orderBy('type')->get();
        });
        if ($vehicle_types->count()) {
            foreach ($vehicle_types as $vehicle) {
                if ($vehicle->icon)
                    $vehicle->icon = asset('uploads/vehicles/' . @$vehicle->icon);
            }
        }
        return response()
            ->json([
                'status' => true,
                'data' => $vehicle_types,
            ], 200);
    }


    public function isValidRidingRequest($request, $next)
    {
        $user = $request->user();
        // dd($user);
        $validation = Validator::make($request->all(),  [
            "riding_request_id" => "required|numeric|exists:riding_requests,id",
        ]);

        if ($validation->fails()) {
            // dd($validation);
            return response()->json([
                'status' => false,
                "status_code" => 422,
                "message" => mapErrorMessage($validation)
            ], 422);
        }
        // dd($request->riding_id);
        // dd($user->id);
        $riding_reuqest  = RidingRequest::where('id', $request->riding_request_id)
            ->where('rider_id', $user->id)
            ->first();
        // dd($riding_reuqest);
        if (!$riding_reuqest) {
            return response()->json([
                'status' => false,
                'stutus_code' => 404,
                "message" => ["Invalid riding request."]
            ], 404);
        }
        return $next($request);
    }


    /*
    * @param1 : pass current latitude of the customer
    * @param2 : pass current longitude of the customer
    * @param3: pass the radius in meter within how much distance you wanted to fiter
    */
    public function findNerestRider($latitude, $longitude, $radius, $vehicle_type, $rejected_riders = null)
    {
        /*
         * using eloquent approach, make sure to replace the "Restaurant" with your actual model name
         * replace 6371000 with 6371 for kilometer and 3956 for miles
         */
        $query = Rider::selectRaw("riders.address,riders.user_id,riders.gender,riders.refer_code,riders.photo,riders.rider_status,riders.is_verified,riders.online_status,riders.current_lat,riders.current_lng, riders.bearing, users.id, riders.past_lat, riders.past_lng, users.name,users.mobile,riders.vehicle_info,
                         ( 6371000 * acos( cos( radians(?) ) *
                           cos( radians( riders.current_lat ) )
                           * cos( radians( riders.current_lng ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( riders.current_lat ) ) )
                         ) AS distance", [$latitude, $longitude, $latitude])

            ->leftJoin('users', 'users.id', 'riders.user_id')
            ->where('riders.rider_status', '1')
            ->where('riders.online_status', '1')
            ->where('riders.is_verified', '1');


        // $query = $query->whereNoTIn('riding_requests.riding_status',  ['accepted', "move_customer", "reach_customer",'riding', "reached_destination"]);
        if ($rejected_riders) {
            $query = $query->whereNoTIn('users.id', $rejected_riders);
        }

        $query = $query->where('online_status', '=', 1)
            ->where('vehicle_info->vehicle_type', $vehicle_type)
            ->having("distance", "<", $radius)

            ->orderBy("distance", 'asc')
            ->offset(0)
            ->limit(20)
            ->get();
        // dd($rider);
        $rider = $query;
        // dd($rider);
        return $rider;
    }


    public function getProvinces(Request $request)
    {
        $provinces = District::select('province_id')->groupBy('province_id')->orderBy('province_id')->get();
        if ($provinces->count()) {
            $provincesdata =  [];
            foreach ($provinces as $province) {
                $data = [
                    'province_id' => $province->province_id
                ];
                if ($province->province_id == '2.1') {
                    $data['name'] =  "Province 1";
                }
                if ($province->province_id == '2.2') {
                    $data['name'] =  "Province 2";
                }
                if ($province->province_id == '2.3') {
                    $data['name'] =  "Province 3";
                }
                if ($province->province_id == '2.4') {
                    $data['name'] =  "Province 4";
                }
                if ($province->province_id == '2.5') {
                    $data['name'] =  "Province 5";
                }
                if ($province->province_id == '2.6') {
                    $data['name'] =  "Province 6";
                }
                if ($province->province_id == '2.7') {
                    $data['name'] =  "Province 7";
                }
                $provincesdata[]  = $data;
            }
        }
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'provinces' => $provincesdata
        ], 200);
    }
    public function getDistricts(Request $request)
    {

        $provinces = Province::select("id", 'eng_name')
            ->with(['get_districts' => function ($qr) {
                return  $qr->select('id', 'dist_name', 'province_id');
            }])
            ->get();
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'provinces' => $provinces,
        ], 200);
    }
    protected function getOtp()
    {
        return  rand(100000, 999999);
    }
    protected function calculateAmount($request, $riding_charge, $coupon = null)
    {
        // here request is riding_request
        $data = [
            'current_address' => $request->current_address,
            'destination_address' => $request->destination_address,
            'current_lat' => $request->current_lat,
            'current_lng' => $request->current_lng,
            'vehicle_type_id' => $request->vehicle_type_id,
            'destination_lat' => $request->destination_lat,
            'destination_lng' => $request->destination_lng,
            'is_shared_ride' => $request->is_shared_ride,
            'duration' => intval(@$request->duration)
        ];

        $base_cost = $riding_charge->base_cost;  // NPR minimum charge for riding 
        $min_length = $riding_charge->base_distance; // charge applicable for minimum distance 
        $unit_cost = $riding_charge->unit_cost; // NPR  cost per  km

        $app_setting = AppSetting::select('from_time', 'to_time', 'commission', 'vat', 'vat_discount_status', 'vat_status')->latest()->first();

        if ($riding_charge->commission_status == '2' && $riding_charge->commission > 0) {
            $service_charge = $riding_charge->commission;
        } else if ($app_setting->commission) {
            $service_charge = $app_setting->commission;
        } else {
            $service_charge = null;
        }

        // dd($app_setting);
        $from_time = null;
        $to_time = null;
        $vat  = null;
        $vat_before_discount  = null;
        if ($app_setting) {
            if ($app_setting->from_time && $app_setting->to_time) {
                $from_time = date('H', strtotime(date('Y-m-d ' . $app_setting->from_time)));
                // dd($from_time);
                $to_time = date('H', strtotime(date('Y-m-d ' . $app_setting->to_time)));
            }
            if ($app_setting->vat && $app_setting->vat_status == '1') {
                if ($app_setting->vat_discount_status == '1') {
                    $vat_before_discount = false; // vat_before_discount true if vat_discont_status  = 0 ,  vat_before_discount is false if vat_discount_status = 1
                } else if ($app_setting->vat_discount_status == '0') {
                    $vat_before_discount = true;
                }
                if ($app_setting->vat > 0 && $app_setting->vat < 100) {
                    $vat = $app_setting->vat;
                }
            }
        }


        $total_amount = getRidingAmount(round($request->riding_distance, 2),  $min_length, $base_cost, $unit_cost);
        $data['total_amount'] = $total_amount;
        $data['initial_amount'] = $total_amount;

        // calculate Riding cost if customer riding within night riding  range 

        $night_charge_percent = null;
        $night_riding_charge = 0;
        if (date('H') >= $from_time    && date('H') <= $to_time) {
            $night_charge_percent = $riding_charge->night_cost;
        }
        // dd($night_charge_percent);

        if ($night_charge_percent) {
            $night_riding_charge = ($data['total_amount'] * $night_charge_percent) / 100;
            $data['total_amount'] = $data['total_amount'] + $night_riding_charge;
        }
        // dd($data);
        // dd($night_riding_charge);
        $data['night_charge_percent'] = $night_charge_percent;
        $data['night_riding_charge'] = $night_riding_charge;

        // vat calculation before  discount 
        if ($vat && $vat_before_discount == '0') {
            $data['riding_vat_status'] = '0';
            $vat_amount = ($data['total_amount'] * $vat) / 100;
            $data['total_amount'] = $data['total_amount'] + $vat_amount;
            $data['vat_percent']  = $vat;
            $data['vat_amount'] = ceil($vat_amount);
        }
        /*
        check coupon  code and amount
        coupon code calcuation starts from here 
        discount_amount / discount_percent // coupon_code 
        */
        // dd($data);

        $discount_amount = 0;
        $discount_percent = 0;
        if ($coupon) {
            // condition check in helper.php 
            switch ($coupon->coupon_type) {
                case 'F':
                    # 'F' => 'Flat Discount',---------------------------
                    $discount_amount = ceil($coupon->flat_amount);
                    break;
                case 'P':
                    // 'P' => 'Percentage Discount', ----------------------
                    $discount_amount = ceil(($data['total_amount'] * $coupon->percent) / 100);
                    break;
                case 'FA':
                    // 'Flat Discount on Amount Spent', ------------------
                    if ($data['total_amount'] >= $coupon->spent_amount) {
                        $discount_amount = $coupon->spent_amount;
                    }
                    break;
                case 'FD':
                    // 'Flat Discount on Distance Travelled' --------------------
                    if ($riding_charge->distance >= $coupon->distance) {
                        $discount_amount = ceil(($data['total_amount'] * $coupon->percent) / 100);
                    }
                    break;
                case 'PA':
                    //   // 'PA' => 'Percentage Discount on Amount Spent' --------------------
                    if ($data['total_amount'] >= $coupon->spent_amount) {
                        $discount_amount = $coupon->spent_amount;
                    }
                    break;
                case 'PD':
                    // 'PD' => 'Percentage Discount on Distance Travelled' --------------------
                    if ($riding_charge->distance >= $coupon->distance) {
                        $discount_amount = ceil(($data['total_amount'] * $coupon->percent) / 100);
                    }
                    break;
                case 'FAD':
                    // 'FAD' => 'Flat Discount on Amount Spent and Distance Travelled' --------------------
                    if ($riding_charge->distance >= $coupon->distance && $data['total_amount'] >= $coupon->spent_amount) {
                        $discount_amount = $coupon->flat_amount;
                    }
                    break;
                case 'PAD':
                    // 'PAD' =>'Percentage Discount on Amount Spent and Distance Travelled' --------------------
                    if ($riding_charge->distance >= $coupon->distance && $data['total_amount'] >= $coupon->spent_amount) {
                        $discount_amount = ceil(($data['total_amount'] * $coupon->percent) / 100);
                    }
                    break;
                default:
                    $discount_amount = 0;
                    break;
            }
            $discount_percent = round((100 * $discount_amount) / $data['total_amount'], 2);

            $data['total_amount'] = $data['total_amount']  - $discount_amount;
            $data['discount_amount'] = $discount_amount;
            $data['discount_percent'] = $discount_percent;
        }

        /*
        check coupon  code and amount
        coupon code calcuation ends here 
        */

        // waiting time cost  
        // waiting time is substraction of total duration 
        if ($request->total_waiting_time && $riding_charge->waiting_time &&  $riding_charge->waiting_cost) {
            if ($request->total_waiting_time > $riding_charge->waiting_time) {
                $waiting_time = $request->total_waiting_time - $riding_charge->waiting_time;
                $total_waiting_cost =  $waiting_time * $riding_charge->waiting_cost;
                $data['total_amount'] = $data['total_amount'] + $total_waiting_cost;
                $data['total_waiting_cost'] = $total_waiting_cost;
                $data['total_waiting_time'] = $waiting_time;
                $data['waiting_time'] = $riding_charge->waiting_time;
                $data['waiting_cost'] =$riding_charge->waiting_cost;
            }
        }


        // Commission /service charge 
        // dd($data);
        if ($service_charge) {
            $service_charge_amount = ceil(($data['total_amount'] * $service_charge) / 100);
            $data['total_amount'] = $data['total_amount'] + $service_charge_amount;
            $data['service_charge_amount'] = $service_charge_amount;
            $data['service_charge_percent'] = intval($service_charge);
        }


        // total amount after adding vat amount 
        if ($vat && $vat_before_discount == '1') {
            $data['riding_vat_status'] = '1';
            $vat_amount = ($data['total_amount'] * $vat) / 100;
            $data['total_amount'] = $data['total_amount'] + $vat_amount;
            $data['vat_percent']  =  $vat;
            $data['vat_amount'] = ceil($vat_amount);
        }



        // dd($data);
        $data['total_amount']  =  ceil($data['total_amount']);

        // dd($data);
        $data['riding_distance'] = round($request->riding_distance, 2);
        $data['base_distance'] = $min_length;
        $data['base_cost'] = $base_cost;
        $data['unit_cost'] = $unit_cost;
        return $data;
    }
    public function getRidingCharge($request)
    {
        $riding_charge = City::selectRaw(
            "cities.latitude,cities.name,cities.longitude, cities.radius, riding_costs.base_distance, 
        riding_costs.vehicle_type_id,
        riding_costs.base_cost,
        riding_costs.unit_cost,
        riding_costs.extra_time_unit,
        riding_costs.extra_time_cost,
        riding_costs.waiting_cost,
        riding_costs.night_cost,
        vehicle_types.commission,
        vehicle_types.commission_status,
        
        (( 6371 * acos( cos( radians(?) ) *
        cos( radians( cities.latitude ) )
        * cos( radians( cities.longitude ) - radians(?)
        ) + sin( radians(?) ) *
        sin( radians( cities.latitude ) ) )
      ) - cities.radius) AS different
                         ",
            [$request->current_lat, $request->current_lng, $request->current_lat]
        )
            ->leftJoin('riding_costs', 'riding_costs.city', 'cities.id')
            ->leftJoin('vehicle_types', 'vehicle_types.id', 'riding_costs.vehicle_type_id')
            ->where('cities.status', '1')
            ->where('vehicle_type_id', $request->vehicle_type_id)
            ->where('riding_costs.status', 'active')
            ->having('different',  "<=", 0)
            ->orderBy('radius', 'ASC')
            ->first();
        return $riding_charge;
    }
    // public function sendNoficiation($request)
    // {
    //     // $pushnotification = PushNotification::where('id', $id)->first();
    //     // dd($pushnotification);
    //     // var_dump($type,$user_id,$title,$description);exit();
    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "POST",
    //         CURLOPT_POSTFIELDS => '{
    //                                         "to":"/topics/all",
    //                                         "data":{
    //                                             "title":"' . $request->title . '",
    //                                             "type" :"' . $request->type . '",
    //                                             "message":"' . $request->description . '"
    //                                             "slug":"' . $request->slug . '"
    //                                             "image":"' . asset('uploads/pushnotifications/' . $request->image) . '"
    //                                         },
    //                                         "android":{
    //                                             "notification":{
    //                                                 "sound":"default"
    //                                             }
    //                                         }
    //                                     }',
    //         CURLOPT_HTTPHEADER => array(
    //             "Authorization: key=env('FIRE_BASE_API')",
    //             "Content-Type: application/json",
    //             "Postman-Token: ef8f2298-8743-4576-9a66-5065f361124f",
    //             "cache-control: no-cache"
    //         ),
    //     ));
    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);
    //     curl_close($curl);
    //     //   echo $response;
    //     if (isset($response)) {
    //         return [
    //             'status' => true,
    //             'message' => 'Notification send successfully.'
    //         ];
    //         // return redirect('/ns-admin/pushnotifications')->with('success', 'Notification send successfully.');
    //     } else {
    //         return [
    //             'status' => false,
    //             "message" =>  'Notification send fail.'
    //         ];
    //         // return redirect('/ns-admin/pushnotifications')->with('success', 'Notification send fail.');
    //     }
    // }
}

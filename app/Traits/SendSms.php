<?php

namespace App\Traits;

use App\Models\SmsSetting;
use GuzzleHttp\Client;

trait SendSms
{

    public function SendSMS($phone, $otp)
    {
        $client = new Client();
        $smsSetting = SmsSetting::orderBy('created_at', 'desc')->where('status', '1')->first();
        // dd($smsSetting);

        if (!$smsSetting) {
            return response()->json([
                'status' => false,
                "status_code" => 422,
                "message" => 'SMS Setting Not Found'
            ], 422);
        }
        $headers = [
            "Authorization" => $smsSetting->token,
            "Content-Type" => "application/json",
            "cache-control" => "no-cache",
            'token' => $smsSetting->token,
        ];
        $data = json_encode([
            'token' => $smsSetting->token,
            'from'  => $smsSetting->identity,
            'to'    => $phone,
            'text'  => "Dear Customer your OTP is " . $otp
        ]);
        try {
            $client = new Client();
            $response = $client->post($smsSetting->api, [
                "headers" => $headers,
                "body" => $data
            ]);
            // dd($response);
            // return "OTP sent successfully.";
            // dd($response->getStatusCode());
            // return $response;
            return $response->getStatusCode();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function notifyToMobile($phone,$type)
    {
        // $phone = 9846641469;
        if ($type == 'accepted') {
            $message = "Dear customer your riding request has been accepted. Rider name   $phone";
        }
        $client = new Client();
        $smsSetting = SmsSetting::orderBy('created_at', 'desc')->where('status', '1')->first();
        // dd($smsSetting);

        if (!$smsSetting) {
            return response()->json([
                'status' => false,
                "status_code" => 422,
                "message" => 'SMS Setting Not Found'
            ], 422);
        }
        $headers = [
            "Authorization" => $smsSetting->token,
            "Content-Type" => "application/json",
            "cache-control" => "no-cache",
            'token' => $smsSetting->token,
        ];
        $data = json_encode([
            'token' => $smsSetting->token,
            'from'  => $smsSetting->identity,
            'to'    => $phone,
            'text'  => $message
        ]);
        try {
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

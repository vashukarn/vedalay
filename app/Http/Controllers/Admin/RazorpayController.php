<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    public function index()
    {
        return view('admin.shared.thankyou');
    }

    public function razorPaySuccess(Request $request)
    {
        $input = $request->all();
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
            } catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }
        
        \Session::put('success', 'Payment successful');
        return redirect()->back();
    }

    public function store(Request $request)
    {
        //
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
        //
    }

    public function destroy($id)
    {
        //
    }
}

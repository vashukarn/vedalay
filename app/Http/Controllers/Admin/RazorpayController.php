<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    public function index()
    {
        return view('admin.shared.thankyou');
    }

    public function store(Request $request)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'payment_id' => $request->payment_id,
            'type' => 'Razorpay',
            'amount' => $request->amount,
        ];
        try {
            DB::beginTransaction();
            Fee::where('id', $request->fee)->first()->delete();
            Payment::create($data);
            DB::commit();
            $request->session()->flash('success', 'Payment credited successfully.');
            return redirect()->back();
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

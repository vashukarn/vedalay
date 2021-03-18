<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }
    protected function getpayment($request)
    {
        if (Auth::user()->type == 'student') {
            $query = $this->payment->orderBy('id', 'DESC')->where('user_id', Auth::user()->id);
        } else {
            $query = $this->payment->orderBy('id', 'DESC');
        }
        if ($request->student) {
            $student = $request->student;
            $query = $query->where('user_id', $student);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $classes = Level::all();
        $temp = Student::get();
        $filter = [];
        foreach ($temp as $key => $value) {
            $filter[$value->user_id] = $value->get_user->name . ' - ' . $value->phone;
        }
        foreach ($classes as $value) {
            if (isset($value->section)) {
                $levels[$value->id] = $value->standard . ' - Section: ' . $value->section;
            } else {
                $levels[$value->id] = $value->standard;
            }
        }
        $data = $this->getpayment($request);
        $data = [
            'data' => $data,
            'levels' => $levels,
            'filter' => $filter,
        ];
        return view('admin/payment/list')->with($data);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }
    public function show($id)
    {
    }
}

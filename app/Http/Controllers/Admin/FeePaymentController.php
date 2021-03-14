<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdvanceFee;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Level;
use App\Models\Notification;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeePaymentController extends Controller
{
    public function __construct(FeePayment $feepayment)
    {
        $this->middleware(['permission:feepayment-list|feepayment-create|feepayment-edit|feepayment-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:feepayment-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:feepayment-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:feepayment-delete'], ['only' => ['destroy']]);
        $this->feepayment = $feepayment;
    }
    protected function getFeeDetails(Request $request)
    {
        $fee = Fee::where('student_id', $request->id)->where('rollback', '0')->select('title', 'tuition_fee','exam_fee','transport_fee','stationery_fee','sports_fee','club_fee','hostel_fee','laundry_fee','education_tax','eca_fee','late_fine','extra_fee','total_amount','created_at')->get();
        return response()->json($fee);
    }
    protected function getFeePayment($request)
    {
        if (Auth::user()->type == 'student') {
            $query = $this->feepayment->orderBy('id', 'DESC')->where('student_id', Auth::user()->id);
        } else {
            $query = $this->feepayment->orderBy('id', 'DESC');
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getFeePayment($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/feepayment/list')->with($data);
    }

    public function create()
    {
        $feepayment_info = null;
        $temp = Session::all();
        foreach ($temp as $value) {
            $session[$value->id] = $value->start_year.' - ' .$value->end_year;
        }
        $classes = Level::all();
        foreach ($classes as $value) {
            if(isset($value->section)){
                $levels[$value->id] = $value->standard.' - Section: ' .$value->section;
            }
            else{
                $levels[$value->id] = $value->standard;
            }
        }
        $title = 'Pay Fee';
        $data = [
            'title' => $title,
            'feepayment_info' => $feepayment_info,
            'session' => $session,
            'levels' => $levels,
        ];
        return view('admin/feepayment/form')->with($data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'session' => 'required',
            'level_id' => 'required',
            'student_id' => 'required',
            'total_amount' => 'required',
            'payment_method' => 'required',
            'transfer_date' => 'required',
            'tuition_fee' => 'nullable|numeric',
            'exam_fee' => 'nullable|numeric',
            'transport_fee' => 'nullable|numeric',
            'stationery_fee' => 'nullable|numeric',
            'sports_fee' => 'nullable|numeric',
            'club_fee' => 'nullable|numeric',
            'hostel_fee' => 'nullable|numeric',
            'laundry_fee' => 'nullable|numeric',
            'education_tax' => 'nullable|numeric',
            'eca_fee' => 'nullable|numeric',
            'late_fine' => 'nullable|numeric',
            'extra_fee' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
        ]);
        DB::beginTransaction();
        try {
                FeePayment::create([
                    'session' => $request->session,
                    'level_id' => $request->level_id,
                    'student_id' => $request->student_id,
                    'tuition_fee' => $request->tuition_fee,
                    'exam_fee' => $request->exam_fee,
                    'transport_fee' => $request->transport_fee,
                    'stationery_fee' => $request->stationery_fee,
                    'sports_fee' => $request->sports_fee,
                    'club_fee' => $request->club_fee,
                    'hostel_fee' => $request->hostel_fee,
                    'laundry_fee' => $request->laundry_fee,
                    'education_tax' => $request->education_tax,
                    'eca_fee' => $request->education_tax,
                    'late_fine' => $request->late_fine,
                    'extra_fee' => $request->extra_fee,
                    'total_amount' => $request->total_amount,
                    'payment_method' => $request->payment_method,
                    'bank_ifsc' => $request->bank_ifsc,
                    'bank_accountno' => $request->bank_accountno,
                    'card_type' => $request->card_type,
                    'transfer_phone' => $request->transfer_phone,
                    'upi_type' => $request->upi_type,
                    'transfer_date' => $request->transfer_date,
                    'remarks' => $request->remarks,
                    'created_by' => Auth::user()->id,
                ]);
            $fee = Fee::where('student_id', $request->student_id)->get();
            $rem_fee = 0;
            $tuition_fee = $request->tuition_fee;
            $exam_fee = $request->exam_fee;
            $transport_fee = $request->transport_fee;
            $stationery_fee = $request->stationery_fee;
            $sports_fee = $request->sports_fee;
            $club_fee = $request->club_fee;
            $hostel_fee = $request->hostel_fee;
            $laundry_fee = $request->laundry_fee;
            $education_tax = $request->education_tax;
            $eca_fee = $request->eca_fee;
            $late_fine = $request->late_fine;
            $extra_fee = $request->extra_fee;
            $total_amount = $request->total_amount;

            foreach ($fee as $key => $value) {
                $single = Fee::find($value->id);
                if($single->tuition_fee > 0){
                    $single->tuition_fee = $single->tuition_fee - $tuition_fee;
                    $tuition_fee = abs($single->tuition_fee);
                    if($single->tuition_fee < 0)
                    $single->tuition_fee = 0;
                }
                if($single->exam_fee > 0){
                    $single->exam_fee = $single->exam_fee - $exam_fee;
                    $exam_fee = abs($single->exam_fee);
                    if($single->exam_fee < 0)
                    $single->exam_fee = 0;
                }
                if($single->transport_fee > 0){
                    $single->transport_fee = $single->transport_fee - $transport_fee;
                    $transport_fee = abs($single->transport_fee);
                    if($single->transport_fee < 0)
                    $single->transport_fee = 0;
                }
                if($single->stationery_fee > 0){
                    $single->stationery_fee = $single->stationery_fee - $stationery_fee;
                    $stationery_fee = abs($single->stationery_fee);
                    if($single->stationery_fee < 0)
                    $single->stationery_fee = 0;
                }
                if($single->sports_fee > 0){
                    $single->sports_fee = $single->sports_fee - $sports_fee;
                    $sports_fee = abs($single->sports_fee);
                    if($single->sports_fee < 0)
                    $single->sports_fee = 0;
                }
                if($single->club_fee > 0){
                    $single->club_fee = $single->club_fee - $club_fee;
                    $club_fee = abs($single->club_fee);
                    if($single->club_fee < 0)
                    $single->club_fee = 0;
                }
                if($single->hostel_fee > 0){
                    $single->hostel_fee = $single->hostel_fee - $hostel_fee;
                    $hostel_fee = abs($single->hostel_fee);
                    if($single->hostel_fee < 0)
                    $single->hostel_fee = 0;
                }
                if($single->laundry_fee > 0){
                    $single->laundry_fee = $single->laundry_fee - $laundry_fee;
                    $laundry_fee = abs($single->laundry_fee);
                    if($single->laundry_fee < 0)
                    $single->laundry_fee = 0;
                }
                if($single->education_tax > 0){
                    $single->education_tax = $single->education_tax - $education_tax;
                    $education_tax = abs($single->education_tax);
                    if($single->education_tax < 0)
                    $single->education_tax = 0;
                }
                if($single->eca_fee > 0){
                    $single->eca_fee = $single->eca_fee - $eca_fee;
                    $eca_fee = abs($single->eca_fee);
                    if($single->eca_fee < 0)
                    $single->eca_fee = 0;
                }
                if($single->late_fine > 0){
                    $single->late_fine = $single->late_fine - $late_fine;
                    $late_fine = abs($single->late_fine);
                    if($single->late_fine < 0)
                    $single->late_fine = 0;
                }
                if($single->extra_fee > 0){
                    $single->extra_fee = $single->extra_fee - $extra_fee;
                    $extra_fee = abs($single->extra_fee);
                    if($single->extra_fee < 0)
                    $single->extra_fee = 0;
                }

                if($single->tuition_fee == 0 && $single->exam_fee == 0 && $single->transport_fee == 0 && $single->stationery_fee == 0 && $single->sports_fee == 0 && $single->club_fee == 0 && $single->hostel_fee == 0 && $single->laundry_fee == 0 && $single->education_tax == 0 && $single->eca_fee == 0 && $single->late_fine == 0 && $single->extra_fee == 0){
                    $single->delete();
                }
                else{
                    $single->save();
                }
            }
            $rem_fee = $tuition_fee + $exam_fee + $transport_fee + $stationery_fee + $sports_fee + $club_fee + $hostel_fee + $laundry_fee + $education_tax + $eca_fee + $late_fine + $extra_fee;
            if($rem_fee > 0){
                AdvanceFee::create([
                    'student_id' => $request->student_id,
                    'amount' => $rem_fee,
                    'session' => $request->session,
                    'created_by' => Auth::user()->id,
                    'level_id' => $request->level_id,
                ]);
            }
            Notification::create([
                'title' => 'Fee Paid Successfully',
                'link' => route('feepayment.index'),
                'user_id' => $request->student_id,
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            $request->session()->flash('success', 'Payment added successfully.');
            return redirect()->route('feepayment.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}

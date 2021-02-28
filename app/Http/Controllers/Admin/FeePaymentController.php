<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Level;
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
        $fee = Fee::where('student_id', $request->id)->where('rollback', '0')->select('title', 'month', 'fees', 'created_at')->get();
        return response()->json($fee);
    }
    protected function getFeePayment($request)
    {
        $query = $this->feepayment->orderBy('id', 'DESC');
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
        // dd($request->fee_details);
        $this->validate($request, [
            'session' => 'required',
            'level_id' => 'required',
            'student_id' => 'required',
            'total_amount' => 'required',
            'payment_method' => 'required',
            'transfer_date' => 'required',
        ]);
        DB::beginTransaction();
        try {
                // FeePayment::create([
                //     'session' => $request->session,
                //     'level_id' => $request->level_id,
                //     'student_id' => $request->student_id,
                //     'fee_details' => $request->fee_details,
                //     'payment_method' => $request->payment_method,
                //     'bank_ifsc' => $request->bank_ifsc,
                //     'bank_accountno' => $request->bank_accountno,
                //     'card_type' => $request->card_type,
                //     'transfer_phone' => $request->transfer_phone,
                //     'upi_type' => $request->upi_type,
                //     'transfer_date' => $request->transfer_date,
                //     'remarks' => $request->remarks,
                // ]);
            $fee = Fee::where('student_id', $request->student_id)->get();
            $tuition_fee = $request->fee_details['tuition_fee'];
            $exam_fee = $request->fee_details['exam_fee'];
            $transport_fee = $request->fee_details['transport_fee'];
            $stationery_fee = $request->fee_details['stationery_fee'];
            $sports_fee = $request->fee_details['sports_fee'];
            $club_fee = $request->fee_details['club_fee'];
            $hostel_fee = $request->fee_details['hostel_fee'];
            $laundry_fee = $request->fee_details['laundry_fee'];
            $education_tax = $request->fee_details['education_tax'];
            $eca_fee = $request->fee_details['eca_fee'];
            $late_fine = $request->fee_details['late_fine'];
            $extra_fee = $request->fee_details['extra_fee'];
            foreach ($fee as $key => $value) {
                if($tuition_fee > 0){
                    $singlefee = Fee::find($value->id);
                    if($singlefee->fees['tuition_fee'] > 0){
                        if($tuition_fee > 0){
                            $tuition_fee = $singlefee->fees['tuition_fee'] - $tuition_fee;
                        }
                        else{
                            break;
                        }
                    }
                    if($singlefee->fees['exam_fee'] > 0){
                        if($exam_fee > 0){
                            $exam_fee = $singlefee->fees['exam_fee'] - $exam_fee;
                        }
                        else{
                            break;
                        }
                    }
                    if($singlefee->fees['transport_fee'] > 0){
                        if($transport_fee > 0){
                            $transport_fee = $singlefee->fees['transport_fee'] - $transport_fee;
                        }
                        else{
                            break;
                        }
                    }
                    if($singlefee->fees['stationery_fee'] > 0){
                        if($stationery_fee > 0){
                            $stationery_fee = $singlefee->fees['stationery_fee'] - $stationery_fee;
                        }
                        else{
                            break;
                        }
                    }
                    if($singlefee->fees['sports_fee'] > 0){
                        if($sports_fee > 0){
                            $sports_fee = $singlefee->fees['sports_fee'] - $sports_fee;
                        }
                        else{
                            break;
                        }
                    }
                    if($singlefee->fees['club_fee'] > 0){
                        if($club_fee > 0){
                            $club_fee = $singlefee->fees['club_fee'] - $club_fee;
                        }
                        else{
                            break;
                        }
                    }
                    if($singlefee->fees['hostel_fee'] > 0){
                        if($hostel_fee > 0){
                            $hostel_fee = $singlefee->fees['hostel_fee'] - $hostel_fee;
                        }
                        else{
                            break;
                        }
                    }
                    if($singlefee->fees['laundry_fee'] > 0){
                        if($laundry_fee > 0){
                            $laundry_fee = $singlefee->fees['laundry_fee'] - $laundry_fee;
                        }
                        else{
                            break;
                        }
                    }
                    if($singlefee->fees['education_tax'] > 0){
                        if($education_tax > 0){
                            $education_tax = $singlefee->fees['education_tax'] - $education_tax;
                        }
                        else{
                            break;
                        }
                    }
                    if($singlefee->fees['eca_fee'] > 0){
                        if($eca_fee > 0){
                            $eca_fee = $singlefee->fees['eca_fee'] - $eca_fee;
                        }
                        else{
                            break;
                        }
                    }
                    if($singlefee->fees['late_fine'] > 0){
                        if($late_fine > 0){
                            $late_fine = $singlefee->fees['late_fine'] - $late_fine;
                        }
                        else{
                            break;
                        }
                    }
                    if($singlefee->fees['extra_fee'] > 0){
                        if($extra_fee > 0){
                            $extra_fee = $singlefee->fees['extra_fee'] - $extra_fee;
                        }
                        else{
                            break;
                        }
                    }
                    $fee = [
                        'tuition_fee' => $tuition_fee > 0 ? $tuition_fee : '0',
                        'exam_fee' => $exam_fee > 0 ? $exam_fee : '0',
                        'transport_fee' => $transport_fee > 0 ? $transport_fee : '0',
                        'stationery_fee' => $stationery_fee > 0 ? $stationery_fee : '0',
                        'sports_fee' => $sports_fee > 0 ? $sports_fee : '0',
                        'club_fee' => $club_fee > 0 ? $club_fee : '0',
                        'hostel_fee' => $hostel_fee > 0 ? $hostel_fee : '0',
                        'laundry_fee' => $laundry_fee > 0 ? $laundry_fee : '0',
                        'education_tax' => $education_tax > 0 ? $education_tax : '0',
                        'eca_fee' => $eca_fee > 0 ? $eca_fee : '0',
                        'late_fine' => $late_fine > 0 ? $late_fine : '0',
                        'extra_fee' => $extra_fee > 0 ? $extra_fee : '0',
                    ];
                    $tuition_fee = abs($tuition_fee);
                    $exam_fee = abs($exam_fee);
                    $transport_fee = abs($transport_fee);
                    $stationery_fee = abs($stationery_fee);
                    $sports_fee = abs($sports_fee);
                    $club_fee = abs($club_fee);
                    $hostel_fee = abs($hostel_fee);
                    $laundry_fee = abs($laundry_fee);
                    $education_tax = abs($education_tax);
                    $eca_fee = abs($eca_fee);
                    $late_fine = abs($late_fine);
                    $extra_fee = abs($extra_fee);
                    $singlefee->fees = $fee;
                    $singlefee->save();
                }
                $advance = abs($tuition_fee) + abs($exam_fee) + abs($transport_fee) + abs($stationery_fee) + abs($sports_fee) + abs($club_fee) + abs($hostel_fee) + abs($laundry_fee) + abs($education_tax) + abs($eca_fee) + abs($late_fine) + abs($extra_fee);
            }
            DB::commit();
            dd($advance);
            dd("Stop");
            $request->session()->flash('success', 'Payment added successfully.');
            return redirect()->route('feepayment.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function edit($id)
    {
        $feepayment_info = $this->feepayment->find($id);
        if (!$feepayment_info) {
            abort(404);
        }
        $title = 'Edit feepayment';
        $data = [
            'title' => $title,
            'feepayment_info' => $feepayment_info,
        ];
        return view('admin/feepayment/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $feepayment_info = $this->feepayment->find($id);
        if (!$feepayment_info) {
            abort(404);
        }
        $this->validate($request, [
            'start_year' => 'required|numeric|min:2021|max:2030|different:end_year',
            'end_year' => 'required|numeric|min:2022|max:2031',
        ]);
        DB::beginTransaction();
        try {
            $feepayment_info->start_year = $request->start_year;
            $feepayment_info->end_year = $request->end_year;
            $feepayment_info->updated_by = Auth::user()->id;
            $feepayment_info->save();
            DB::commit();
            $request->session()->flash('success', 'feepayment updated successfully.');
            return redirect()->route('feepayment.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $feepayment_info = $this->feepayment->find($id);
        if (!$feepayment_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $feepayment_info->updated_by = Auth::user()->id;
            $feepayment_info->save();
            $feepayment_info->delete();
            $request->session()->flash('success', 'feepayment removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

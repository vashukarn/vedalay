<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Level;
use App\Models\Session;
use Illuminate\Http\Request;

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
        $this->validate($request, [
            'start_year' => 'required|numeric|unique:feepayments|min:2021|max:2030|different:end_year',
            'end_year' => 'required|numeric|unique:feepayments|min:2022|max:2031',
        ]);
        DB::beginTransaction();
        try {
                feepayment::create([
                    'start_year' => $request->start_year,
                    'end_year' => $request->end_year,
                    'created_by' => Auth::user()->id,
                ]);
            DB::commit();
            $request->feepayment()->flash('success', 'feepayment added successfully.');
            return redirect()->route('feepayment.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->feepayment()->flash('error', $error->getMessage());
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
            $request->feepayment()->flash('success', 'feepayment updated successfully.');
            return redirect()->route('feepayment.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->feepayment()->flash('error', $error->getMessage());
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
            $request->feepayment()->flash('success', 'feepayment removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->feepayment()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

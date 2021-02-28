<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Level;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    public function __construct(Fee $fee)
    {
        $this->middleware(['permission:fee-list|fee-create|fee-edit|fee-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:fee-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:fee-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:fee-delete'], ['only' => ['destroy']]);
        $this->fee = $fee;
    }
    public function getStudents(Request $request)
    {
        $students = Student::where('level_id', $request->id)->get();
        $data = null;
        foreach ($students as $value) {
            $data[] = [
                'id' => $value->user_id,
                'value' => $value->get_user->name . ' - ' . $value->phone,
            ];
        }
        if($data){
            return response()->json($data);
        }
        else{
            $data = "No Data Found";
            return response()->json($data);
        }
    }
    protected function getFee($request)
    {
        $query = $this->fee->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getFee($request);
        $levels = Level::pluck('standard', 'id');
        $data = [
            'data' => $data,
            'levels' => $levels,
        ];
        return view('admin/fee/list')->with($data);
    }

    public function create()
    {
        $fee_info = null;
        $title = 'Add Fee';
        $classes = Level::all();
        foreach ($classes as $value) {
            if(isset($value->section)){
                $levels[$value->id] = $value->standard.' - Section: ' .$value->section;
            }
            else{
                $levels[$value->id] = $value->standard;
            }
        }
        $data = [
            'title' => $title,
            'fee_info' => $fee_info,
            'levels' => $levels,
        ];
        return view('admin/fee/form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'month' => 'required|required|numeric|in:1,2,3,4,5,6,7,8,9,10,11,12',
            'level' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $timestamp = strtotime(date('Y-m-d'));
            foreach ($request->student as $value) {
                
                $fee = [
                    'tuition_fee' => htmlentities($request->tuition_fee),
                    'exam_fee' => htmlentities($request->exam_fee),
                    'transport_fee' => htmlentities($request->transport_fee),
                    'stationery_fee' => htmlentities($request->stationery_fee),
                    'sports_fee' => htmlentities($request->sports_fee),
                    'club_fee' => htmlentities($request->club_fee),
                    'hostel_fee' => htmlentities($request->hostel_fee),
                    'laundry_fee' => htmlentities($request->laundry_fee),
                    'education_tax' => htmlentities($request->education_tax),
                    'eca_fee' => htmlentities($request->eca_fee),
                    'late_fine' => htmlentities($request->late_fine),
                    'extra_fee' => htmlentities($request->extra_fee),
                    'total_amount' => 
                    htmlentities($request->tuition_fee) +
                    htmlentities($request->exam_fee) +
                    htmlentities($request->transport_fee) +
                    htmlentities($request->stationery_fee) +
                    htmlentities($request->sports_fee) +
                    htmlentities($request->club_fee) +
                    htmlentities($request->hostel_fee) +
                    htmlentities($request->laundry_fee) +
                    htmlentities($request->education_tax) +
                    htmlentities($request->eca_fee) +
                    htmlentities($request->late_fine) +
                    htmlentities($request->extra_fee),
                ];
                Fee::create([
                    'title' => $request->title,
                    'month' => $request->month,
                    'created_by' => Auth::user()->id,
                    'added_by' => 'Fee Management',
                    'fees' => $fee,
                    'student_id' => $value,
                    'unique' => $timestamp,
                    'level_id' => $request->level,
                ]);
            }
            DB::commit();
            $request->session()->flash('success', 'Fee added successfully.');
            return redirect()->route('fee.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function rollbackTransaction(Request $request, $fee)
    {
        $fee_info = $this->fee->where('unique', $fee)->get();
        if (!$fee_info) {
            abort(404);
        }
        $temp = $fee_info[0];
        foreach($fee_info as $value){
            $fee = [
                'tuition_fee' => $value->fees['tuition_fee'] - $temp->fees['tuition_fee'],
                'exam_fee' => $value->fees['exam_fee'] - $temp->fees['exam_fee'],
                'transport_fee' => $value->fees['transport_fee'] - $temp->fees['transport_fee'],
                'stationery_fee' => $value->fees['stationery_fee'] - $temp->fees['stationery_fee'],
                'club_fee' => $value->fees['club_fee'] - $temp->fees['club_fee'],
                'hostel_fee' => $value->fees['hostel_fee'] - $temp->fees['hostel_fee'],
                'laundry_fee' => $value->fees['laundry_fee'] - $temp->fees['laundry_fee'],
                'education_tax' => $value->fees['education_tax'] - $temp->fees['education_tax'],
                'eca_fee' => $value->fees['eca_fee'] - $temp->fees['eca_fee'],
                'late_fine' => $value->fees['late_fine'] - $temp->fees['late_fine'],
                'extra_fee' => $value->fees['extra_fee'] - $temp->fees['extra_fee'],
                'total_amount' => $value->fees['total_amount'] - $temp->fees['total_amount']
            ];
            $single = $this->fee->find($value->id);
            $single->month = date('m');
            $single->added_by = "Roll backed";
            $single->updated_by = Auth::user()->id;
            $single->fees = $fee;
            $single->rollback = 1;
            $single->save();
        }
        return redirect()->back();
    }
}

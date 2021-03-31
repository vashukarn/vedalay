<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendFeeAdditionJob;
use App\Mail\FeeAdditionMail;
use App\Models\Fee;
use App\Models\Level;
use App\Models\AppSetting;
use App\Models\Attendance;
use App\Models\Notification;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        if ($data) {
            return response()->json($data);
        } else {
            $data = "No Data Found";
            return response()->json($data);
        }
    }
    protected function getFee($request)
    {
        if (Auth::user()->type == 'student') {
            $query = $this->fee->orderBy('id', 'DESC')->where('student_id', Auth::user()->id)->where('rollback', '0');
        } else {
            $query = $this->fee->orderBy('id', 'DESC');
        }
        $query = $this->fee->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('level_id', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $classes = Level::all();
        foreach ($classes as $value) {
            if (isset($value->section)) {
                $levels[$value->id] = $value->standard . ' - Section: ' . $value->section;
            } else {
                $levels[$value->id] = $value->standard;
            }
        }
        $sitesetting = AppSetting::orderBy('created_at', 'desc')->first();
        $data = $this->getFee($request);
        $data = [
            'data' => $data,
            'sitesetting' => $sitesetting,
            'payment' => GETAPPSETTING()['razorpay_payment'],
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
            if (isset($value->section)) {
                $levels[$value->id] = $value->standard . ' - Section: ' . $value->section;
            } else {
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
            'student' => 'required',
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
            'level' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $timestamp = strtotime(date('Y-m-d H:i:s'));
            foreach ($request->student as $value) {
                Fee::create([
                    'title' => htmlentities($request->title),
                    'created_by' => Auth::user()->id,
                    'added_by' => 'Fee Management',
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
                    'total_amount' => htmlentities($request->tuition_fee ?? 0) + htmlentities($request->exam_fee ?? 0) + htmlentities($request->transport_fee ?? 0) + htmlentities($request->stationery_fee ?? 0) + htmlentities($request->sports_fee ?? 0) + htmlentities($request->club_fee ?? 0) + htmlentities($request->hostel_fee ?? 0) + htmlentities($request->laundry_fee ?? 0) + htmlentities($request->education_tax ?? 0) + htmlentities($request->eca_fee ?? 0) + htmlentities($request->late_fine ?? 0) + htmlentities($request->extra_fee ?? 0),
                    'student_id' => $value,
                    'unique' => $timestamp,
                    'level_id' => htmlentities($request->level),
                ]);
                Notification::create([
                    'title' => 'Fee Added to Account',
                    'link' => route('fee.index'),
                    'user_id' => $value,
                    'created_by' => Auth::user()->id,
                ]);
                DB::commit();
                // dispatch(new SendFeeAdditionJob($value));
            }
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
        foreach ($fee_info as $value) {
            $single = $this->fee->find($value->id);
            if ($single->tuition_fee > 0 && $temp->tuition_fee > 0) {
                $single->tuition_fee = $single->tuition_fee - $temp->tuition_fee;
            }
            if ($single->exam_fee > 0 && $temp->exam_fee > 0) {
                $single->exam_fee = $single->exam_fee - $temp->exam_fee;
            }
            if ($single->transport_fee > 0 && $temp->transport_fee > 0) {
                $single->transport_fee = $single->transport_fee - $temp->transport_fee;
            }
            if ($single->stationery_fee > 0 && $temp->stationery_fee > 0) {
                $single->stationery_fee = $single->stationery_fee - $temp->stationery_fee;
            }
            if ($single->club_fee > 0 && $temp->club_fee > 0) {
                $single->club_fee = $single->club_fee - $temp->club_fee;
            }
            if ($single->hostel_fee > 0 && $temp->hostel_fee > 0) {
                $single->hostel_fee = $single->hostel_fee - $temp->hostel_fee;
            }
            if ($single->laundry_fee > 0 && $temp->laundry_fee > 0) {
                $single->laundry_fee = $single->laundry_fee - $temp->laundry_fee;
            }
            if ($single->education_tax > 0 && $temp->education_tax > 0) {
                $single->education_tax = $single->education_tax - $temp->education_tax;
            }
            if ($single->eca_fee > 0 && $temp->eca_fee > 0) {
                $single->eca_fee = $single->eca_fee - $temp->eca_fee;
            }
            if ($single->late_fine > 0 && $temp->late_fine > 0) {
                $single->late_fine = $single->late_fine - $temp->late_fine;
            }
            if ($single->extra_fee > 0 && $temp->extra_fee > 0) {
                $single->extra_fee = $single->extra_fee - $temp->extra_fee;
            }
            if ($single->total_amount > 0 && $temp->total_amount > 0) {
                $single->total_amount = $single->total_amount - $temp->total_amount;
            }
            $single->added_by = "Roll backed";
            $single->updated_by = Auth::user()->id;
            $single->rollback = 1;
            $single->save();
        }
        return redirect()->back();
    }
    public function show($id)
    {
        $student_info = Student::pluck('id', 'user_id');
        $fee_info = $this->fee->find($id);
        if (!$fee_info) {
            abort(404);
        }
        $title = 'Fee Detail';
        $data = [
            'title' => $title,
            'student_info' => $student_info,
            'fee_info' => $fee_info,
        ];
        return view('admin/fee/show')->with($data);
    }
}

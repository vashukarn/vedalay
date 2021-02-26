<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function __construct(Session $session)
    {
        $this->middleware(['permission:session-list|session-create|session-edit|session-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:session-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:session-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:session-delete'], ['only' => ['destroy']]);
        $this->session = $session;
    }
    protected function getSession($request)
    {
        $query = $this->session->orderBy('id', 'DESC');
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getSession($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/session/list')->with($data);
    }

    public function create()
    {
        $session_info = null;
        $title = 'Add Session';
        $data = [
            'title' => $title,
            'session_info' => $session_info,
        ];
        return view('admin/session/form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:190',
            'type' => 'required|in:Teacher,Staff',
            'month' => 'required|required|numeric|in:1,2,3,4,5,6,7,8,9,10,11,12',
        ]);
        DB::beginTransaction();
        try {
                    $session = [
                        'monthly_session' => $request->monthly_session,
                        'tada' => $request->tada,
                        'extra_class_session' => $request->extra_class_session,
                        'incentive' => $request->incentive,
                        'transport_charges' => $request->transport_charges,
                        'leave_charges' => $request->leave_charges,
                        'bonus' => $request->bonus,
                        'advance_session' => $request->advance_session,
                        'total_amount' => 
                        $request->monthly_session +
                        $request->tada +
                        $request->extra_class_session +
                        $request->incentive -
                        $request->transport_charges -
                        $request->leave_charges +
                        $request->bonus -
                        $request->advance_session
                    ];
                    session::create([
                        'title' => $request->title,
                        'month' => $request->month,
                        'teacher_id' => $request->user,
                        'created_by' => Auth::user()->id,
                        'added_by' => 'session Management',
                        'session' => $session,
                        'level_id' => $request->level,
                    ]);
                    if(isset($request->advance_session)){
                        Advancesession::create([
                            'user_id' => $request->user,
                            'created_by' => Auth::user()->id,
                            'amount' => $request->advance_session,
                        ]);
                    }
            DB::commit();
            $request->session()->flash('success', 'session added successfully.');
            return redirect()->route('session.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function rollbacksession(Request $request, $session)
    {
        $session_info = $this->session->where('unique', $session)->get();
        if (!$session_info) {
            abort(404);
        }
        $temp = $session_info[0];
        foreach($session_info as $value){
            $session = [
                'tuition_session' => $value->sessions['tuition_session'] - $temp->sessions['tuition_session'],
                'exam_session' => $value->sessions['exam_session'] - $temp->sessions['exam_session'],
                'transport_session' => $value->sessions['transport_session'] - $temp->sessions['transport_session'],
                'stationery_session' => $value->sessions['stationery_session'] - $temp->sessions['stationery_session'],
                'club_session' => $value->sessions['club_session'] - $temp->sessions['club_session'],
                'hostel_session' => $value->sessions['hostel_session'] - $temp->sessions['hostel_session'],
                'laundry_session' => $value->sessions['laundry_session'] - $temp->sessions['laundry_session'],
                'eduaction_tax' => $value->sessions['eduaction_tax'] - $temp->sessions['eduaction_tax'],
                'eca_session' => $value->sessions['eca_session'] - $temp->sessions['eca_session'],
                'late_fine' => $value->sessions['late_fine'] - $temp->sessions['late_fine'],
                'extra_session' => $value->sessions['extra_session'] - $temp->sessions['extra_session'],
                'total_amount' => $value->sessions['total_amount'] - $temp->sessions['total_amount']
            ];
            $single = $this->session->find($value->id);
            $single->month = date('m');
            $single->added_by = "Roll backed";
            $single->updated_by = Auth::user()->id;
            $single->sessions = $session;
            $single->rollback = 1;
            $single->save();
        }
        return redirect()->back();
    }
}

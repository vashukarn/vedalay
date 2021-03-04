<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fee;

class UserLogController extends Controller
{
    protected $logactivity=null;
    public function __construct(LogActivity $logActivity)
    {
        $this->middleware(['role:Super Admin']);
        $this->logactivity=$logActivity;
    }
    public function __invoke(Request $request)
    {
        $visible=array(10=>'10', 20=>'20', 50=>'50', 100=>'100');
        if($request->q != null){
            $this->logactivity=$this->logactivity->where('subject', 'LIKE', '%' . $request->q . '%')->orWhere('ip', 'LIKE', '%' . $request->q . '%');
        }
        $this->logactivity=$this->logactivity->with('log_by')->orderBy('id','DESC')->paginate(($request->visible)?$request->visible:20);
        $this->logactivity->appends(['q'=>$request->q,'visible'=>$request->visible]);
        return view('admin.userlog.log',compact('visible'))->with('data',$this->logactivity);
    }

    public function ClearAll(){
        $status=$this->logactivity->truncate();
        $fees = Fee::all();
        foreach ($fees as $value) {
            $single = Fee::find($value->id);
            if($single->tuition_fee == 0 && $single->exam_fee == 0 && $single->transport_fee == 0 && $single->stationery_fee == 0 && $single->sports_fee == 0 && $single->club_fee == 0 && $single->hostel_fee == 0 && $single->laundry_fee == 0 && $single->education_tax == 0 && $single->eca_fee == 0 && $single->late_fine == 0 && $single->extra_fee == 0){
                $single->delete();
            }
        }
        if($status){
            request()->session()->flash('success', 'User-Log Cleared successfully');
        }else{
            request()->session()->flash('error', 'There was problem while deleting User Log');
        }
     return redirect(route('user-log.index'));
     }
}

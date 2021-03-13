<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function __construct(Leave $leave)
    {
        $this->middleware(['permission:leave-list|leave-create|leave-edit|leave-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:leave-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:leave-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:leave-delete'], ['only' => ['destroy']]);
        $this->leave = $leave;
    }

    protected function getleave($request)
    {
        $query = $this->leave->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getleave($request);
        return view('admin/leave/list', compact('data'));
    }

    public function create(Request $request)
    {
        $leave_info = null;
        $title = 'Request Leave';
        return view('admin/leave/form', compact('leave_info', 'title'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'title' => 'required|string|max:190',
            'from_date' => 'required|date',
            'to_date' => 'nullable|date|after:from_date',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);
        $uploaded_image = null;
        if ($request->image)
            $uploaded_image = 'leave/' . uploadFile($request->image, 'leave');

        if ($request->to_date) {
            $datetime1 = new DateTime($request->from_date);
            $datetime2 = new DateTime($request->to_date);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a') + 1;
        } else {
            $days = 1;
        }

        $data = [
            'title' => htmlentities($request->title),
            'from_date' => htmlentities($request->from_date),
            'to_date' => htmlentities($request->to_date),
            'days' => $days,
            'description' => htmlentities($request->description),
            'image' => $uploaded_image,
            'type' => Auth::user()->type,
            'created_by' => Auth::user()->id,
        ];
        try {
            $this->leave->fill($data)->save();
            $request->session()->flash('success', 'Leave requested successfully.');
            return redirect()->route('leave.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function change(Request $request, $id, $change)
    {
        dd($change);
        $leave_info = $this->leave->find($id);
        if (!$leave_info) {
            abort(404);
        }
        return view('admin/leave/form', compact('leave_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $leave_info = $this->leave->find($id);
        if (!$leave_info) {
            abort(404);
        }
        try {
        $this->validate($request, [
            'status' => 'required|in:confirm,reject'
        ]);
            if ($request->status == 'confirm') {
                $leave_info->status = 'ACCEPTED';
            } else {
                $leave_info->status = 'DECLINED';
            }
            $leave_info->save();
            $request->session()->flash('success', 'Leave updated successfully.');
            return redirect()->route('leave.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $leave_info = $this->leave->find($id);
        if (!$leave_info) {
            abort(404);
        }
        try {
            $leave_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'leave deleted successfully.');
            cache()->forget('app_leave');
            return redirect()->route('leave.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}

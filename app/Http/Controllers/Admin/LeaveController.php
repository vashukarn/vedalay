<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function __construct(Leave $leave)
    {
        $this->middleware(['permission:leave-list|leave-create|leave-edit|leave-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:leave-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:leave-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:leave-delete'], ['only' => ['destroy']]);
        $this->leave = $leave;
    }

    protected function getleave($request)
    {
        $query = $this->leave->orderBy('id','DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title',$keyword);
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
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => htmlentities($request->title),
            'sub_title' => htmlentities($request->sub_title),
            'description' => htmlentities($request->description),
            'image' => $request->image ?? null,
            'external_url' => htmlentities($request->external_url),
            'publish_status' => htmlentities($request->publish_status),
            'status' => htmlentities($request->status),
            'created_by' => Auth::user()->id,
        ];
        try {
            $this->leave->fill($data)->save();
            $request->session()->flash('success', 'leave created successfully.');
            return redirect()->route('leave.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $leave_info = $this->leave->find($id);
        if (!$leave_info) {
            abort(404);
        }
        $title = 'Update leave Type';
        return view('admin/leave/form', compact('leave_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $leave_info = $this->leave->find($id);
        if (!$leave_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => htmlentities($request->title),
            'sub_title' => htmlentities($request->sub_title),
            'description' => htmlentities($request->description),
            'external_url' => htmlentities($request->external_url),
            'publish_status' => htmlentities($request->publish_status),
            'status' => htmlentities($request->status),
            'updated_by' => Auth::user()->id,
        ];
        if ($request->image) {
            $data['image'] = $request->image;
        }
        try {
            $leave_info->fill($data)->save();
            $request->session()->flash('success', 'leave updated successfully.');
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestDataController extends Controller
{
    public function __construct(RequestData $requestdata)
    {
        $this->middleware(['permission:requestdata-list|requestdata-create|requestdata-edit|requestdata-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:requestdata-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:requestdata-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:requestdata-delete'], ['only' => ['destroy']]);
        $this->requestdata = $requestdata;
    }
    protected function getrequestdata($request)
    {
        $query = $this->requestdata->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getrequestdata($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/requestdata/list')->with($data);
    }

    public function create()
    {
        $requestdata_info = null;
        $title = 'Add requestdata';
        $data = [
            'title' => $title,
            'requestdata_info' => $requestdata_info,
        ];
        return view('admin/requestdata/form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'job_role' => 'required|string|min:3|max:190',
            'required_no' => 'nullable|numeric',
            'salary' => 'nullable|numeric',
            'publish_status' => 'required|in:1,0',
        ]);
        DB::beginTransaction();
        try {
            requestdata::create([
                'job_role' => htmlentities($request->job_role),
                'publish_status' => htmlentities($request->publish_status),
                'description' => htmlentities($request->description),
                'salary' => htmlentities($request->salary ?? null),
                'required_no' => htmlentities($request->required_no ?? 1),
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            $request->session()->flash('success', 'requestdata added successfully.');
            return redirect()->route('requestdata.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $requestdata_info = $this->requestdata->find($id);
        if (!$requestdata_info) {
            abort(404);
        }
        $title = 'Edit requestdata';
        $data = [
            'title' => $title,
            'requestdata_info' => $requestdata_info,
        ];
        return view('admin/requestdata/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $requestdata_info = $this->requestdata->find($id);
        if (!$requestdata_info) {
            abort(404);
        }
        $this->validate($request, [
            'job_role' => 'required|string|min:3|max:190',
            'required_no' => 'nullable|numeric',
            'salary' => 'nullable|numeric',
            'publish_status' => 'required|in:1,0',
        ]);
        DB::beginTransaction();
        try {
            $requestdata = requestdata::find($id);
            $requestdata->job_role = htmlentities($request->job_role);
            $requestdata->description = htmlentities($request->description);
            $requestdata->salary = htmlentities($request->salary ?? null);
            $requestdata->required_no = htmlentities($request->required_no ?? 1);
            $requestdata->publish_status = htmlentities($request->publish_status);
            $requestdata->updated_by = Auth::user()->id;
            $status = $requestdata->save();
            DB::commit();
            $request->session()->flash('success', 'requestdata updated successfully.');
            return redirect()->route('requestdata.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }

    }

    public function destroy(Request $request, $id)
    {
        $requestdata_info = $this->requestdata->find($id);
        if (!$requestdata_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $requestdata_info->delete();
            $request->session()->flash('success', 'requestdata removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Level;
use App\Models\Result;
use App\Models\Student;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function __construct(Result $result)
    {
        $this->middleware(['permission:result-list|result-create|result-edit|result-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:result-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:result-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:result-delete'], ['only' => ['destroy']]);
        $this->result = $result;
    }
    protected function getresult($request)
    {
        $query = $this->result->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    protected function getResultData(Request $request)
    {
        $exam = Exam::where('level_id', $request->level)->pluck('title', 'id');
        $temp = Student::where('level_id', $request->level)->get();
        $student = [];
        foreach ($temp as $value) {
            $student[$value->user_id] = $value->get_user->name.' - '.$value->phone;
        }
        $data = [
            'exams' => $exam,
            'students' => $student,
        ];
        return response()->json($data);
    }
    public function index(Request $request)
    {
        $data = $this->getresult($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/result/list')->with($data);
    }

    public function create()
    {
        $result_info = null;
        $title = 'Add Result';
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
            'result_info' => $result_info,
            'levels' => $levels,
        ];
        return view('admin/result/form')->with($data);
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
            result::create([
                'job_role' => $request->job_role,
                'publish_status' => $request->publish_status,
                'description' => $request->description,
                'salary' => $request->salary ?? null,
                'required_no' => $request->required_no ?? 1,
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            $request->session()->flash('success', 'result added successfully.');
            return redirect()->route('result.index');
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
        $result_info = $this->result->find($id);
        if (!$result_info) {
            abort(404);
        }
        $title = 'Edit result';
        $data = [
            'title' => $title,
            'result_info' => $result_info,
        ];
        return view('admin/result/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $result_info = $this->result->find($id);
        if (!$result_info) {
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
            $result = result::find($id);
            $result->job_role = $request->job_role;
            $result->description = $request->description;
            $result->salary = $request->salary ?? null;
            $result->required_no = $request->required_no ?? 1;
            $result->publish_status = $request->publish_status;
            $result->updated_by = Auth::user()->id;
            $status = $result->save();
            DB::commit();
            $request->session()->flash('success', 'result updated successfully.');
            return redirect()->route('result.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }

    }

    public function destroy(Request $request, $id)
    {
        $result_info = $this->result->find($id);
        if (!$result_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $result_info->delete();
            $request->session()->flash('success', 'result removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

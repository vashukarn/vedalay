<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Level;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function __construct(Result $result)
    {
        $this->middleware(['permission:result-list|result-create|result-edit|result-delete'], ['only' => ['index']]);
        $this->middleware(['permission:result-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:result-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:result-delete'], ['only' => ['destroy']]);
        $this->result = $result;
    }
    protected function getresult($request)
    {
        if(Auth::user()->type == 'student'){
            $query = $this->result->orderBy('id', 'DESC')->where('student_id', Auth::user()->id)->where('publish_status', '1');
        }
        else{
            $query = $this->result->orderBy('id', 'DESC');
        }
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function addResult(Request $request)
    {
        DB::beginTransaction();
        try {
            $backsubjects = [];
            $marks = [];
            foreach ($request->data[11]['value'] as $item) {
                $marks[$item['value']['subjectid']] = [
                    'name' => $item['value']['subjectname'],
                    'totalmarks' => $item['value']['totmarks'],
                    'passmarks' => $item['value']['passmark'],
                    'marksobtained' => $item['value']['marksobt'],
                    'grade' => $item['value']['grade']
                ];
            }
            if(isset($request->data[12]['value'])){
                foreach ($request->data[12]['value'] as $item) {
                    $backsubjects[$item['id']] = $item['name'];
                }
            }
            $temp = [
                'marks' => $marks,
                'backlogs' => $backsubjects,
                'level_id' => htmlentities($request->data[1]['value']),
                'exam_id' => htmlentities($request->data[2]['value']),
                'student_id' => htmlentities($request->data[3]['value']),
                'total_marks' => htmlentities($request->data[4]['value']),
                'marks_obtained' => htmlentities($request->data[5]['value']),
                'percentage' => htmlentities($request->data[6]['value']),
                'sgpa' => round(htmlentities($request->data[7]['value']), 2),
                'grade' => htmlentities($request->data[8]['value']),
                'status' => htmlentities($request->data[9]['value']),
                'created_by' => Auth::user()->id,
            ];
            if($request->data[10]['value']){
                $temp['withheld_reason'] = $request->data[10]['value'];
            }
            $result = Result::create($temp);
            DB::commit();
            return response()->json($result);
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json($error->getMessage());
        }
    }
    protected function getResultData(Request $request)
    {
        $tempo = Exam::where('level_id', $request->level)->get();
        $temp = Student::where('level_id', $request->level)->get();
        $tempoo = Subject::where('level_id', $request->level)->get();
        $student = [];
        $exam = [];
        foreach ($tempo as $value) {
            $exam[] = [
                'id' => $value->id,
                'value' => $value->title
            ];
        }
        $student = [];
        foreach ($temp as $value) {
            $student[] = [
                'id' => $value->user_id,
                'value' => $value->get_user->name.' - '.$value->phone
            ];
        }
        $subject = [];
        foreach ($tempoo as $value) {
            $subject[] = [
                'id' => $value->id,
                'name' => $value->title,
                'type' => $value->type,
                'value' => $value->value,
            ];
        }
        $data = [
            'exams' => $exam,
            'students' => $student,
            'subjects' => $subject,
        ];
        return response()->json($data);
    }
    public function publishResult($id)
    {
        $result_info = $this->result->find($id);
        if (!$result_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            if($result_info->publish_status){
                $result_info->publish_status = '0';
            }
            else{
                $result_info->publish_status = '1';
            }
            $result_info->updated_by = Auth::user()->id;
            $result_info->save();
            DB::commit();
            return redirect()->back();

        } catch (\Exception $error) {
            DB::rollBack();
            return redirect()->back();
        }
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
        dd($request->all());
        $this->validate($request, [
            'job_role' => 'required|string|min:3|max:190',
            'required_no' => 'nullable|numeric',
            'salary' => 'nullable|numeric',
            'publish_status' => 'required|in:1,0',
        ]);
        DB::beginTransaction();
        try {
            result::create([
                'job_role' => htmlentities($request->job_role),
                'publish_status' => htmlentities($request->publish_status),
                'description' => htmlentities($request->description),
                'salary' => htmlentities($request->salary ?? null),
                'required_no' => htmlentities($request->required_no ?? 1),
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

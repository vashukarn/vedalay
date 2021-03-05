<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Level;
use App\Models\Session;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function __construct(Exam $exam)
    {
        $this->middleware(['permission:exam-list|exam-create|exam-edit|exam-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:exam-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:exam-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:exam-delete'], ['only' => ['destroy']]);
        $this->exam = $exam;
    }
    protected function getexam($request)
    {
        $query = $this->exam->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    protected function getSubjects(Request $request)
    {
        $subjects = Subject::where('publish_status', '1')->where('level_id', $request->level)->pluck('title', 'id');
        return response()->json($subjects);
    }
    public function index(Request $request)
    {
        $subjects = Subject::pluck('title', 'id');
        $data = $this->getexam($request);
        $data = [
            'data' => $data,
            'subjects' => $subjects,
        ];
        return view('admin/exam/list')->with($data);
    }

    public function create()
    {
        $exam_info = null;
        $title = 'Add Exam';
        $temp = Session::all();
        foreach ($temp as $value) {
            $sessions[$value->id] = $value->start_year.' - ' .$value->end_year;
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
        $data = [
            'title' => $title,
            'sessions' => $sessions,
            'levels' => $levels,
            'exam_info' => $exam_info,
        ];
        return view('admin/exam/form')->with($data);
    }
    public function addExam(Request $request)
    {
        DB::beginTransaction();
        try {
            $routine = [];
            for ($i=1; $i <= $request->request_count; $i++) { 
                if($request->data[$i + 7]['value']['subject']){
                    $routine[$request->data[$i + 7]['value']['subject']] = [
                        'date' => $request->data[$i + 7]['value']['date'],
                        'shift' => $request->data[$i + 7]['value']['shift'],
                    ];
                }
            }
            $exam = Exam::create([
                'title' => $request->data[1]['value'],
                'session_id' => $request->data[3]['value'],
                'level_id' => $request->data[4]['value'],
                'exam_routine' => $routine,
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            return response()->json($exam);
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json($error->getMessage());
        }
    }

    public function publishExam($id)
    {
        $exam_info = $this->exam->find($id);
        if (!$exam_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            if($exam_info->publish_status){
                $exam_info->publish_status = '0';
            }
            else{
                $exam_info->publish_status = '1';
            }
            $exam_info->updated_by = Auth::user()->id;
            $exam_info->save();
            DB::commit();
            return redirect()->back();

        } catch (\Exception $error) {
            DB::rollBack();
            return redirect()->back();
        }
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
            exam::create([
                'job_role' => htmlentities($request->job_role),
                'publish_status' => htmlentities($request->publish_status),
                'description' => htmlentities($request->description),
                'salary' => htmlentities($request->salary ?? null),
                'required_no' => htmlentities($request->required_no ?? 1),
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            $request->session()->flash('success', 'exam added successfully.');
            return redirect()->route('exam.index');
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
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy(Request $request, $id)
    {
        $exam_info = $this->exam->find($id);
        if (!$exam_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $exam_info->delete();
            $request->session()->flash('success', 'Exam removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

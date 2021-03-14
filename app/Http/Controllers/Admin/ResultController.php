<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Level;
use App\Models\Notification;
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
        if (Auth::user()->type == 'student') {
            $query = $this->result->orderBy('id', 'DESC')->where('student_id', Auth::user()->id)->where('publish_status', '1');
        } else {
            $query = $this->result->orderBy('id', 'DESC');
        }
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    protected function getSubjectExam(Request $request)
    {
        $examtemp = Exam::where('level_id', $request->exam_id)->get();
        $sublist = Subject::pluck('title', 'id');
        $subject = [];
        foreach ($examtemp as $value) {
            foreach ($value->exam_routine as $key => $item) {
                foreach ($item as $keya => $valuea) {
                    if (isset($valuea['subject'])) {
                        $subject[] = [
                            'id' => $valuea['subject'],
                            'value' => @$sublist[$valuea['subject']],
                        ];
                    }
                }
            }
        }
        $data = [
            'subjects' => $subject,
        ];
        return response()->json($data);
    }
    protected function getResultData(Request $request)
    {
        $examtemp = Exam::where('level_id', $request->level)->get();
        $studtemp = Student::where('level_id', $request->level)->get();
        $student = [];
        $exam = [];
        foreach ($examtemp as $value) {
            $exam[] = [
                'id' => $value->id,
                'value' => $value->title
            ];
        }
        foreach ($studtemp as $value) {
            $student[] = [
                'id' => $value->user_id,
                'value' => $value->get_user->name . ' - ' . $value->phone
            ];
        }
        $data = [
            'exams' => $exam,
            'students' => $student,
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
            if ($result_info->publish_status) {
                $result_info->publish_status = '0';
            } else {
                $result_info->publish_status = '1';
                Notification::create([
                    'title' => 'Exam Result Published',
                    'link' => route('result.index'),
                    'user_id' => $result_info->student_id,
                    'created_by' => Auth::user()->id,
                ]);
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
        $subjects = Subject::pluck('title', 'id');
        $data = [
            'data' => $data,
            'subjects' => $subjects,
        ];
        return view('admin/result/list')->with($data);
    }

    public function create()
    {
        $result_info = null;
        $title = 'Add Result';
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
            'result_info' => $result_info,
            'levels' => $levels,
        ];
        return view('admin/result/form')->with($data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'gper' => 'required|in:Percentage,Grade',
            'level_id' => 'required|numeric',
            'exam_id' => 'required|numeric',
            'student_id' => 'required|numeric',
            'sgpa' => 'nullable|numeric|max:10',
            'marks' => 'required',
            'total_marks' => 'nullable|numeric',
            'marks_obtained' => 'nullable|numeric',
            'percentage' => 'nullable|numeric|max:100',
            'status' => 'required|in:FAIL,PASS,WITHHELD',
        ]);
        DB::beginTransaction();
        try {
            $data = [
                'marks' => $request->marks,
                'backlogs' => $request->backlogs,
                'gper' => $request->gper,
                'total_marks' => $request->total_marks,
                'exam_id' => $request->exam_id,
                'percentage' => $request->percentage,
                'marks_obtained' => $request->marks_obtained,
                'grade' => $request->grade,
                'withheld_reason' => $request->withheld_reason,
                'sgpa' => $request->sgpa,
                'status' => $request->status,
                'student_id' => $request->student_id,
                'level_id' => $request->level_id,
                'created_by' => Auth::user()->id,
            ];
            Result::create($data);
            DB::commit();
            $request->session()->flash('success', 'Result added successfully.');
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

    public function destroy(Request $request, $id)
    {
        $result_info = $this->result->find($id);
        if (!$result_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $result_info->delete();
            $request->session()->flash('success', 'Result removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

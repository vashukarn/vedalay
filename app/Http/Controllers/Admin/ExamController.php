<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendExamPublishJob;
use App\Models\Exam;
use App\Models\Level;
use App\Models\Notification;
use App\Models\Session;
use App\Models\Student;
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
        if (Auth::user()->type == 'student') {
            $studentlevel = Student::where('user_id', Auth::user()->id)->first();
            $query = $this->exam->orderBy('id', 'DESC')->where('level_id', $studentlevel->level_id)->where('publish_status', '1');
        } else {
            $query = $this->exam->orderBy('id', 'DESC');
        }
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    protected function getSubjects(Request $request)
    {
        $subjects = [];
        $temp = Subject::where('publish_status', '1')->where('level_id', $request->level)->get();
        foreach ($temp as $key => $value) {
            $subjects[] = [
                'id' => $value->id,
                'title' => $value->title,
            ];
        }
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
                $students = Student::where('level_id', $exam_info->level_id)->get();
                foreach ($students as $key => $value) {
                    Notification::create([
                        'title' => $exam_info->title.' Published',
                        'link' => route('exam.show', @$exam_info->id),
                        'user_id' => $value->user_id,
                        'created_by' => Auth::user()->id,
                    ]);
                    // $details['id'] = $value->user_id;
                    // $details['title'] = $exam_info->title;
                    // $details['level_id'] = $exam_info->level_id;
                    // $details['session_id'] = $exam_info->session_id;
                    // $details['exam_routine'] = $exam_info->exam_routine;
                    // dispatch(new SendExamPublishJob($details));
                }
            }
            $exam_info->updated_by = Auth::user()->id;
            $exam_info->save();
            DB::commit();
            return redirect()->back();

        } catch (\Exception $error) {
            DB::rollBack();
                dd($error);
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        // dd($request->exam_routine);
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'session_id' => 'required|numeric',
            'level_id' => 'required|numeric',
            'exam_routine' => 'required',
        ]);
        DB::beginTransaction();
        try {
            Exam::create([
                'title' => htmlentities($request->title),
                'session_id' => htmlentities($request->session_id),
                'level_id' => htmlentities($request->level_id),
                'exam_routine' => $request->exam_routine,
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            $request->session()->flash('success', 'Exam added successfully.');
            return redirect()->route('exam.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $exam_info = $this->exam->find($id);
        if (!$exam_info) {
            abort(404);
        }
        $subjects = Subject::pluck('title', 'id');
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
            'exam_info' => $exam_info,
            'subjects' => $subjects,
            'levels' => $levels,
        ];
        return view('admin/exam/show')->with($data);
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

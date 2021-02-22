<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Level;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index(Request $request)
    {
        $data = $this->getexam($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/exam/list')->with($data);
    }

    public function create()
    {
        $exam_info = null;
        $title = 'Add Exam';
        $sessions = Session::pluck('title', 'id');
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
            exam::create([
                'job_role' => $request->job_role,
                'publish_status' => $request->publish_status,
                'description' => $request->description,
                'salary' => $request->salary ?? null,
                'required_no' => $request->required_no ?? 1,
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
        $exam_info = $this->exam->find($id);
        if (!$exam_info) {
            abort(404);
        }
        $title = 'Edit exam';
        $data = [
            'title' => $title,
            'exam_info' => $exam_info,
        ];
        return view('admin/exam/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $exam_info = $this->exam->find($id);
        if (!$exam_info) {
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
            $exam = exam::find($id);
            $exam->job_role = $request->job_role;
            $exam->description = $request->description;
            $exam->salary = $request->salary ?? null;
            $exam->required_no = $request->required_no ?? 1;
            $exam->publish_status = $request->publish_status;
            $exam->updated_by = Auth::user()->id;
            $status = $exam->save();
            DB::commit();
            $request->session()->flash('success', 'exam updated successfully.');
            return redirect()->route('exam.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }

    }

    public function destroy(Request $request, $id)
    {
        $exam_info = $this->exam->find($id);
        if (!$exam_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $user = User::find($exam_info->user_id);
            $exam_info->phone = $exam_info->phone . '-' . time();
            $user->email = $user->email . '-' . time();
            $user->save();
            $exam_info->save();
            $exam_info->delete();
            $user->delete();
            $request->session()->flash('success', 'exam removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

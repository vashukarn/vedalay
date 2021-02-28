<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SubjectController extends Controller
{
    public function __construct(Subject $subject)
    {
        $this->middleware(['permission:subject-list|subject-create|subject-edit|subject-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:subject-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:subject-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:subject-delete'], ['only' => ['destroy']]);
        $this->subject = $subject;
    }
    protected function getSubject($request)
    {
        $query = $this->subject->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getsubject($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/subject/list')->with($data);
    }

    public function create()
    {
        $subject_info = null;
        $title = 'Add Subject';
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
            'subject_info' => $subject_info,
            'levels' => $levels,
        ];
        return view('admin/subject/form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'type' => 'required',
            'value' => 'required',
            'publish_status' => 'required',
            'level' => 'required',
        ]);
        DB::beginTransaction();
        try {
            Subject::create([
                'title' => htmlentities($request->title),
                'level_id' => htmlentities($request->level),
                'type' => htmlentities($request->type),
                'value' => htmlentities($request->value),
                'publish_status' => htmlentities($request->publish_status),
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            $request->session()->flash('success', 'Subject added successfully.');
            return redirect()->route('subject.index');
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
        $subject_info = $this->subject->find($id);
        if (!$subject_info) {
            abort(404);
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
        $title = 'Edit Subject';
        $data = [
            'title' => $title,
            'subject_info' => $subject_info,
            'levels' => $levels,
        ];
        return view('admin/subject/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $subject_info = $this->subject->find($id);
        if (!$subject_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'type' => 'required',
            'value' => 'required',
            'publish_status' => 'required',
            'level' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $subject_info->title = htmlentities($request->title);
            $subject_info->type = htmlentities($request->type);
            $subject_info->value = htmlentities($request->value);
            $subject_info->publish_status = htmlentities($request->publish_status);
            $subject_info->level_id = htmlentities($request->level);
            $subject_info->updated_by = Auth::user()->id;
            $subject_info->save();
            DB::commit();
            $request->session()->flash('success', 'Subject updated successfully.');
            return redirect()->route('subject.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }

    }

    public function destroy(Request $request, $id)
    {
        $subject_info = $this->subject->find($id);
        if (!$subject_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $subject_info->updated_by = Auth::user()->id;
            $subject_info->save();
            $subject_info->delete();
            $request->session()->flash('success', 'subject removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

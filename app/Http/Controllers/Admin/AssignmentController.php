<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function __construct(Assignment $assignment)
    {
        $this->middleware(['permission:assignment-list|assignment-create|assignment-edit|assignment-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:assignment-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:assignment-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:assignment-delete'], ['only' => ['destroy']]);
        $this->assignment = $assignment;
    }
    public function createAssignment($id)
    {
        $subject = Subject::find($id);
        $title = 'Add Assignment';
        $data = [
            'title' => $title,
            'subject_info' => $subject,
            'assignment_info' => null,
        ];
        return view('admin/assignment/form')->with($data);
    }
    
    protected function getAssignment($request)
    {
        $query = $this->assignment->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        
        if(Auth::user()->roles->pluck('name')[0] == 'Student'){
            $level = Student::where('user_id', Auth::user()->id)->pluck('level_id')->first();
            $subject = Subject::where('level_id', $level)->pluck('id');
            $query = $query->whereIn('subject_id', $subject);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getAssignment($request);
        $data = [
            'data' => $data,
            'subject' => Subject::pluck('title', 'id'),
        ];
        return view('admin/assignment/list')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'subject_id' => 'required|numeric',
            'title' => 'required|string|min:3|max:190',
            'deadline' => 'required',
        ]);
        DB::beginTransaction();
        try {
            // dd($request->references);
            Assignment::create([
                'title' => htmlentities($request->title),
                'subject_id' => htmlentities($request->subject_id),
                'deadline' => $request->deadline,
                'description' => $request->description,
                'references' => $request->references,
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            $request->session()->flash('success', 'Assignment added successfully.');
            return redirect()->route('assignment.index');
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

    public function update(Request $request, $id)
    {
        $assignment_info = $this->assignment->find($id);
        if (!$assignment_info) {
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
            $assignment = assignment::find($id);
            $assignment->job_role = htmlentities($request->job_role);
            $assignment->description = htmlentities($request->description);
            $assignment->salary = htmlentities($request->salary ?? null);
            $assignment->required_no = htmlentities($request->required_no ?? 1);
            $assignment->publish_status = htmlentities($request->publish_status);
            $assignment->updated_by = Auth::user()->id;
            $status = $assignment->save();
            DB::commit();
            $request->session()->flash('success', 'assignment updated successfully.');
            return redirect()->route('assignment.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }

    }

    public function destroy(Request $request, $id)
    {
        $assignment_info = $this->assignment->find($id);
        if (!$assignment_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $assignment_info->delete();
            $request->session()->flash('success', 'assignment removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

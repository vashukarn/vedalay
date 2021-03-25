<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct(Task $task)
    {
        $this->task = $task;
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|string|min:3|max:350',
            'deadline' => 'required|date',
        ]);
        DB::beginTransaction();
        try {
            $task = new Task();
            $task->description = htmlentities($request->description);
            $task->deadline = htmlentities($request->deadline);
            $task->created_by = Auth::user()->id;
            $status = $task->save();
            DB::commit();
            if($status){
                $request->session()->flash('success', 'Task added successfully.');
            }
            else{
                $request->session()->flash('error', 'Error while adding task.');
            }
            return redirect()->route('profiledetail');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function changeTaskStatus(Request $request)
    {
        DB::beginTransaction();
        try {
            $task_info = $this->task->find($request->id);
            if($task_info->completion == 'COMPLETE'){
                $task_info->completion = 'INCOMPLETE';
            }
            else{
                $task_info->completion = 'COMPLETE';
            }
            $status = $task_info->save();
            DB::commit();
            return response()->json($status);
        } catch (\Exception $error) {
            DB::rollBack();
            request()->session()->flash('error', $error->getMessage());
            return response()->json($error->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $task_info = $this->task->find($id);
        if (!$task_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $task_info->delete();
            $request->session()->flash('success', 'Task removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

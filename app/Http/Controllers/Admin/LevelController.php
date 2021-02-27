<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function __construct(Level $level)
    {
        $this->middleware(['permission:level-list|level-create|level-edit|level-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:level-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:level-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:level-delete'], ['only' => ['destroy']]);
        $this->level = $level;
    }
    protected function getLevel($request)
    {
        $query = $this->level->orderBy('id', 'DESC');
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getLevel($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/level/list')->with($data);
    }

    public function create()
    {
        $level_info = null;
        $title = 'Add Level';
        $data = [
            'title' => $title,
            'level_info' => $level_info,
        ];
        return view('admin/level/form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'standard' => 'required',
        ]);
        DB::beginTransaction();
        try {
                Level::create([
                    'standard' => $request->standard,
                    'section' => $request->section,
                    'created_by' => Auth::user()->id,
                ]);
            DB::commit();
            $request->session()->flash('success', 'Level added successfully.');
            return redirect()->route('level.index');
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
        $level_info = $this->level->find($id);
        if (!$level_info) {
            abort(404);
        }
        $title = 'Edit Level';
        $data = [
            'title' => $title,
            'level_info' => $level_info,
        ];
        return view('admin/level/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $level_info = $this->level->find($id);
        if (!$level_info) {
            abort(404);
        }
        $this->validate($request, [
            'standard' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $level_info->standard = $request->standard;
            $level_info->section = $request->section;
            $level_info->updated_by = Auth::user()->id;
            $level_info->save();
            DB::commit();
            $request->session()->flash('success', 'Level updated successfully.');
            return redirect()->route('level.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $level_info = $this->level->find($id);
        if (!$level_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $level_info->updated_by = Auth::user()->id;
            $level_info->save();
            $level_info->delete();
            $request->session()->flash('success', 'Level removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

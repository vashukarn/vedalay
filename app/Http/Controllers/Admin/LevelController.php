<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

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
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

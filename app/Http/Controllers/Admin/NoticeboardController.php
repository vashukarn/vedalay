<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NoticeBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoticeboardController extends Controller
{
    public function __construct(NoticeBoard $noticeboard)
    {
        $this->middleware(['permission:noticeboard-list|noticeboard-create|noticeboard-edit|noticeboard-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:noticeboard-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:noticeboard-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:noticeboard-delete'], ['only' => ['destroy']]);
        $this->noticeboard = $noticeboard;
    }
    protected function getNoticeBoard($request)
    {
        $query = $this->noticeboard->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getNoticeBoard($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/noticeboard/list')->with($data);
    }

    public function publishNotice($id)
    {
        $noticeboard_info = $this->noticeboard->find($id);
        if (!$noticeboard_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            if($noticeboard_info->publish_status){
                $noticeboard_info->publish_status = '0';
            }
            else{
                $noticeboard_info->publish_status = '1';
            }
            $noticeboard_info->updated_by = Auth::user()->id;
            $noticeboard_info->save();
            DB::commit();
            return redirect()->back();

        } catch (\Exception $error) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function create()
    {
        $noticeboard_info = null;
        $title = 'Add Noticeboard';
        $data = [
            'title' => $title,
            'noticeboard_info' => $noticeboard_info,
        ];
        return view('admin/noticeboard/form')->with($data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'date' => 'required|date',
        ]);
        DB::beginTransaction();
        try {
            $data = [
                'title' => htmlentities($request->title),
                'description' => $request->description,
                'date' => htmlentities($request->date),
                'image' => $request->image,
                'created_by' => Auth::user()->id,
            ];
            NoticeBoard::create($data);
            DB::commit();
            $request->session()->flash('success', 'Notice added successfully.');
            return redirect()->route('noticeboard.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $noticeboard_info = $this->noticeboard->find($id);
        if (!$noticeboard_info) {
            abort(404);
        }
        $data = [
            'noticeboard_info' => $noticeboard_info,
        ];
        return view('admin/noticeboard/show')->with($data);
    }

    public function edit($id)
    {
        $noticeboard_info = $this->noticeboard->find($id);
        if (!$noticeboard_info) {
            abort(404);
        }
        $title = 'Edit Notice';
        $data = [
            'title' => $title,
            'noticeboard_info' => $noticeboard_info,
        ];
        return view('admin/noticeboard/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $noticeboard_info = $this->noticeboard->find($id);
        if (!$noticeboard_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'date' => 'required|date',
        ]);
        DB::beginTransaction();
        try {
            $noticeboard = NoticeBoard::find($id);
            $noticeboard->title = htmlentities($request->title);
            $noticeboard->description = $request->description;
            $noticeboard->date = $request->date;
            $noticeboard->updated_by = Auth::user()->id;
            if (isset($request->image)) {
                $noticeboard->image = htmlentities($request->image);
            }
            $noticeboard->save();
            DB::commit();
            $request->session()->flash('success', 'Notice updated successfully.');
            return redirect()->route('noticeboard.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }

    }

    public function destroy(Request $request, $id)
    {
        $noticeboard_info = $this->noticeboard->find($id);
        if (!$noticeboard_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $noticeboard_info->delete();
            $request->session()->flash('success', 'noticeboard removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

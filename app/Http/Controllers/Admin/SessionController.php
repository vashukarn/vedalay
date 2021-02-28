<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function __construct(Session $session)
    {
        $this->middleware(['permission:session-list|session-create|session-edit|session-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:session-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:session-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:session-delete'], ['only' => ['destroy']]);
        $this->session = $session;
    }
    protected function getSession($request)
    {
        $query = $this->session->orderBy('id', 'DESC');
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getSession($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/session/list')->with($data);
    }

    public function create()
    {
        $session_info = null;
        $title = 'Add Session';
        $data = [
            'title' => $title,
            'session_info' => $session_info,
        ];
        return view('admin/session/form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'start_year' => 'required|numeric|unique:sessions|min:2021|max:2030|different:end_year',
            'end_year' => 'required|numeric|unique:sessions|min:2022|max:2031',
        ]);
        DB::beginTransaction();
        try {
                Session::create([
                    'start_year' => htmlentities($request->start_year),
                    'end_year' => htmlentities($request->end_year),
                    'created_by' => Auth::user()->id,
                ]);
            DB::commit();
            $request->session()->flash('success', 'Session added successfully.');
            return redirect()->route('session.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function edit($id)
    {
        $session_info = $this->session->find($id);
        if (!$session_info) {
            abort(404);
        }
        $title = 'Edit Session';
        $data = [
            'title' => $title,
            'session_info' => $session_info,
        ];
        return view('admin/session/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $session_info = $this->session->find($id);
        if (!$session_info) {
            abort(404);
        }
        $this->validate($request, [
            'start_year' => 'required|numeric|min:2021|max:2030|different:end_year',
            'end_year' => 'required|numeric|min:2022|max:2031',
        ]);
        DB::beginTransaction();
        try {
            $session_info->start_year = htmlentities($request->start_year);
            $session_info->end_year = htmlentities($request->end_year);
            $session_info->updated_by = Auth::user()->id;
            $session_info->save();
            DB::commit();
            $request->session()->flash('success', 'Session updated successfully.');
            return redirect()->route('session.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $session_info = $this->session->find($id);
        if (!$session_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $session_info->updated_by = Auth::user()->id;
            $session_info->save();
            $session_info->delete();
            $request->session()->flash('success', 'Session removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

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
                    'start_year' => $request->start_year,
                    'end_year' => $request->end_year,
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
}

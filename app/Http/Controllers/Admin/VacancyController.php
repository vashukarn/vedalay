<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VacancyController extends Controller
{
    public function __construct(Vacancy $vacancy)
    {
        $this->middleware(['permission:vacancy-list|vacancy-create|vacancy-edit|vacancy-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:vacancy-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:vacancy-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:vacancy-delete'], ['only' => ['destroy']]);
        $this->vacancy = $vacancy;
    }
    protected function getvacancy($request)
    {
        $query = $this->vacancy->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getvacancy($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/vacancy/list')->with($data);
    }

    public function create()
    {
        $vacancy_info = null;
        $title = 'Add Vacancy';
        $data = [
            'title' => $title,
            'vacancy_info' => $vacancy_info,
        ];
        return view('admin/vacancy/form')->with($data);
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
            Vacancy::create([
                'job_role' => $request->job_role,
                'publish_status' => $request->publish_status,
                'description' => $request->description,
                'salary' => $request->salary ?? null,
                'required_no' => $request->required_no ?? 1,
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            $request->session()->flash('success', 'Vacancy added successfully.');
            return redirect()->route('vacancy.index');
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
        $vacancy_info = $this->vacancy->find($id);
        if (!$vacancy_info) {
            abort(404);
        }
        $title = 'Edit Vacancy';
        $data = [
            'title' => $title,
            'vacancy_info' => $vacancy_info,
        ];
        return view('admin/vacancy/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $vacancy_info = $this->vacancy->find($id);
        if (!$vacancy_info) {
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
            $vacancy = Vacancy::find($id);
            $vacancy->job_role = $request->job_role;
            $vacancy->description = $request->description;
            $vacancy->salary = $request->salary ?? null;
            $vacancy->required_no = $request->required_no ?? 1;
            $vacancy->publish_status = $request->publish_status;
            $vacancy->updated_by = Auth::user()->id;
            $status = $vacancy->save();
            DB::commit();
            $request->session()->flash('success', 'Vacancy updated successfully.');
            return redirect()->route('vacancy.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }

    }

    public function destroy(Request $request, $id)
    {
        $vacancy_info = $this->vacancy->find($id);
        if (!$vacancy_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $vacancy_info->delete();
            $request->session()->flash('success', 'Vacancy removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

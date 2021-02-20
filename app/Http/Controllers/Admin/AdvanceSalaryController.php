<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdvanceSalary;
use Illuminate\Http\Request;

class AdvanceSalaryController extends Controller
{public function __construct(AdvanceSalary $advancesalary)
    {
        $this->middleware(['permission:advancesalary-list|advancesalary-create|advancesalary-edit|advancesalary-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:advancesalary-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:advancesalary-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:advancesalary-delete'], ['only' => ['destroy']]);
        $this->advancesalary = $advancesalary;
    }
    protected function getAdvanceSalary($request)
    {
        $query = $this->advancesalary->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getAdvanceSalary($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/advancesalary/list')->with($data);
    }
}

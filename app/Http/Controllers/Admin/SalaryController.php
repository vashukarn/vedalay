<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdvanceSalary;
use App\Models\Salary;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    public function __construct(Salary $salary)
    {
        $this->middleware(['permission:salary-list|salary-create|salary-edit|salary-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:salary-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:salary-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:salary-delete'], ['only' => ['destroy']]);
        $this->salary = $salary;
    }
    public function getData(Request $request)
    {
        if ($request->type == "Teacher") {
            $temp = User::where('type', 'teacher')->where('publish_status', '1')->get();
            foreach ($temp as $value) {
                $data[] = [
                    'id' => $value->id,
                    'value' => $value->name . ' - ' . $value->email,
                ];
            }
        } elseif ($request->type == "Staff") {
            $temp = User::where('type', 'staff')->where('publish_status', '1')->get();
            foreach ($temp as $value) {
                $data[] = [
                    'id' => $value->id,
                    'value' => $value->name . ' - ' . $value->email,
                ];
            }
        } else {
            $data = 'Invalid Argument Supplied';
        }
        return response()->json($data);
    }
    protected function getsalary($request)
    {
        $query = $this->salary->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getsalary($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/salary/list')->with($data);
    }

    public function create()
    {
        $salary_info = null;
        $title = 'Add Salary';
        $data = [
            'title' => $title,
            'salary_info' => $salary_info,
        ];
        return view('admin/salary/form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:190',
            'type' => 'required|in:Teacher,Staff',
            'month' => 'required|required|numeric|in:1,2,3,4,5,6,7,8,9,10,11,12',
            'monthly_salary' => 'nullable|numeric',
            'tada' => 'nullable|numeric',
            'extra_class' => 'nullable|numeric',
            'incentive' => 'nullable|numeric',
            'transport_charges' => 'nullable|numeric',
            'leave_charges' => 'nullable|numeric',
            'bonus' => 'nullable|numeric',
            'advance_salary' => 'nullable|numeric',
            
        ]);
        DB::beginTransaction();
        try {
            Salary::create([
                'title' => htmlentities($request->title),
                'monthly_salary' => htmlentities($request->monthly_salary),
                'tada' => htmlentities($request->tada),
                'extra_class' => htmlentities($request->extra_class),
                'incentive' => htmlentities($request->incentive),
                'transport_charges' => htmlentities($request->transport_charges),
                'leave_charges' => htmlentities($request->leave_charges),
                'bonus' => htmlentities($request->bonus),
                'advance_salary' => htmlentities($request->advance_salary),
                'total_amount' => htmlentities($request->total_amount) + htmlentities($request->monthly_salary) + htmlentities($request->tada) + htmlentities($request->extra_class) + htmlentities($request->incentive) + htmlentities($request->transport_charges) + htmlentities($request->leave_charges) + htmlentities($request->bonus) + htmlentities($request->advance_salary) + htmlentities($request->total_amount),
                'month' => htmlentities($request->month),
                'user_id' => htmlentities($request->user),
                'created_by' => Auth::user()->id,
                'added_by' => 'Salary Management',
                'level_id' => htmlentities($request->level),
            ]);
            if (isset($request->advance_salary)) {
                AdvanceSalary::create([
                    'user_id' => $request->user,
                    'created_by' => Auth::user()->id,
                    'amount' => $request->advance_salary,
                ]);
            }
            DB::commit();
            $request->session()->flash('success', 'Salary added successfully.');
            return redirect()->route('salary.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function rollbackSalary(Request $request, $salary)
    {
        $salary_info = $this->salary->where('unique', $salary)->get();
        if (!$salary_info) {
            abort(404);
        }
        $temp = $salary_info[0];
        foreach ($salary_info as $value) {
            $single = $this->salary->find($value->id);
            $single->title = $temp->title;
            $single->monthly_salary = $temp->monthly_salary;
            $single->tada = $temp->tada;
            $single->extra_class = $temp->extra_class;
            $single->incentive = $temp->incentive;
            $single->transport_charges = $temp->transport_charges;
            $single->leave_charges = $temp->leave_charges;
            $single->bonus = $temp->bonus;
            $single->advance_salary = $temp->advance_salary;
            $single->total_amount = $temp->total_amount;
            $single->month = date('m');
            $single->added_by = "Roll backed";
            $single->updated_by = Auth::user()->id;
            $single->salarys = $salary;
            $single->rollback = 1;
            $single->save();
        }
        return redirect()->back();
    }
}

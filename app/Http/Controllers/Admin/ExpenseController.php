<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function __construct(Expense $expense)
    {
        $this->middleware(['permission:expense-list|expense-create|expense-edit|expense-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:expense-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:expense-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:expense-delete'], ['only' => ['destroy']]);
        $this->expense = $expense;
    }

    protected function getExpense($request)
    {
        $query = $this->expense->orderBy('id','DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title',$keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getExpense($request);
        return view('admin/expenses/list', compact('data'));
    }

    public function create(Request $request)
    {
        $expense_info = null;
        $title = 'Add Expense';
        return view('admin/expenses/form', compact('expense_info', 'title'));
        
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'paid_to' => 'required',
            'amount' => 'required|numeric',
        ]);
        $data = [
            'title' => htmlentities($request->title),
            'paid_to' => htmlentities($request->paid_to),
            'amount' => htmlentities($request->amount),
            'remarks' => htmlentities($request->remarks),
            'image' => $request->image ?? null,
            'created_by' => Auth::user()->id,
        ];
        try {
            $this->expense->fill($data)->save();
            $request->session()->flash('success', 'Expense created successfully.');
            cache()->forget('app_expenses');
            return redirect()->route('expense.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $expense_info = $this->expense->find($id);
        if (!$expense_info) {
            abort(404);
        }
        $title = 'Update expense Type';
        return view('admin/expenses/form', compact('expense_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $expense_info = $this->expense->find($id);
        if (!$expense_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'paid_to' => 'required',
            'amount' => 'required|numeric',
        ]);
        $data = [
            'title' => htmlentities($request->title),
            'paid_to' => htmlentities($request->paid_to),
            'amount' => htmlentities($request->amount),
            'remarks' => htmlentities($request->remarks),
            'updated_by' => Auth::user()->id,
        ];
        if ($request->image) {
            $data['image'] = $request->image;
        }
        try {
            $expense_info->fill($data)->save();
            $request->session()->flash('success', 'Expense updated successfully.');
            return redirect()->route('expense.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $expense_info = $this->expense->find($id);
        if (!$expense_info) {
            abort(404);
        }
        try {
            $expense_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'expense deleted successfully.');
            cache()->forget('app_expenses');
            return redirect()->route('expense.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}

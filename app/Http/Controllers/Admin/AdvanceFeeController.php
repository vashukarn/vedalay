<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdvanceFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvanceFeeController extends Controller
{
    public function __construct(AdvanceFee $feeadvance)
    {
        $this->middleware(['permission:feeadvance-list|feeadvance-create|feeadvance-edit|feeadvance-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:feeadvance-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:feeadvance-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:feeadvance-delete'], ['only' => ['destroy']]);
        $this->feeadvance = $feeadvance;
    }
    protected function pay($id)
    {
        dd($id);
    }
    protected function getFeeAdvance($request)
    {
        $query = $this->feeadvance->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getFeeAdvance($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/feeadvance/list')->with($data);
    }

    // public function create()
    // {
    //     $feeadvance_info = null;
    //     $title = 'Add feeadvance';
    //     $data = [
    //         'title' => $title,
    //         'feeadvance_info' => $feeadvance_info,
    //     ];
    //     return view('admin/feeadvance/form')->with($data);
    // }

    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'job_role' => 'required|string|min:3|max:190',
    //         'required_no' => 'nullable|numeric',
    //         'salary' => 'nullable|numeric',
    //         'publish_status' => 'required|in:1,0',
    //     ]);
    //     DB::beginTransaction();
    //     try {
    //         feeadvance::create([
    //             'job_role' => htmlentities($request->job_role),
    //             'publish_status' => htmlentities($request->publish_status),
    //             'description' => htmlentities($request->description),
    //             'salary' => htmlentities($request->salary ?? null),
    //             'required_no' => htmlentities($request->required_no ?? 1),
    //             'created_by' => Auth::user()->id,
    //         ]);
    //         DB::commit();
    //         $request->session()->flash('success', 'feeadvance added successfully.');
    //         return redirect()->route('feeadvance.index');
    //     } catch (\Exception $error) {
    //         DB::rollBack();
    //         $request->session()->flash('error', $error->getMessage());
    //         return redirect()->back();
    //     }
    // }

    // public function show($id)
    // {
    //     //
    // }

    // public function edit($id)
    // {
    //     $feeadvance_info = $this->feeadvance->find($id);
    //     if (!$feeadvance_info) {
    //         abort(404);
    //     }
    //     $title = 'Edit feeadvance';
    //     $data = [
    //         'title' => $title,
    //         'feeadvance_info' => $feeadvance_info,
    //     ];
    //     return view('admin/feeadvance/form')->with($data);
    // }

    // public function update(Request $request, $id)
    // {
    //     $feeadvance_info = $this->feeadvance->find($id);
    //     if (!$feeadvance_info) {
    //         abort(404);
    //     }
    //     $this->validate($request, [
    //         'job_role' => 'required|string|min:3|max:190',
    //         'required_no' => 'nullable|numeric',
    //         'salary' => 'nullable|numeric',
    //         'publish_status' => 'required|in:1,0',
    //     ]);
    //     DB::beginTransaction();
    //     try {
    //         $feeadvance = feeadvance::find($id);
    //         $feeadvance->job_role = htmlentities($request->job_role);
    //         $feeadvance->description = htmlentities($request->description);
    //         $feeadvance->salary = htmlentities($request->salary ?? null);
    //         $feeadvance->required_no = htmlentities($request->required_no ?? 1);
    //         $feeadvance->publish_status = htmlentities($request->publish_status);
    //         $feeadvance->updated_by = Auth::user()->id;
    //         $status = $feeadvance->save();
    //         DB::commit();
    //         $request->session()->flash('success', 'feeadvance updated successfully.');
    //         return redirect()->route('feeadvance.index');
    //     } catch (\Exception $error) {
    //         DB::rollBack();
    //         $request->session()->flash('error', $error->getMessage());
    //         return redirect()->back();
    //     }

    // }

    public function destroy(Request $request, $id)
    {
        $feeadvance_info = $this->feeadvance->find($id);
        if (!$feeadvance_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $feeadvance_info->delete();
            $request->session()->flash('success', 'Fee Advance removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}

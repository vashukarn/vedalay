<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function __construct(Inventory $inventory)
    {
        $this->middleware(['permission:inventory-list|inventory-create|inventory-edit|inventory-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:inventory-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:inventory-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:inventory-delete'], ['only' => ['destroy']]);
        $this->inventory = $inventory;
    }

    protected function getItem($request)
    {
        $query = $this->inventory->orderBy('id','DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title',$keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getItem($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/inventory/list')->with($data);
    }

    public function create(Request $request)
    {
        $inventory_info = null;
        $title = 'Add or Remove Inventory Stock';
        $items = InventoryItem::pluck('title', 'id');
        $data = [
            'inventory_info' => $inventory_info,
            'title' => $title,
            'items' => $items,
        ];
        return view('admin/inventory/form')->with($data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'item_id' => 'required|numeric',
            'act' => 'required|in:ADD,REMOVE',
            'quantity' => 'required|numeric',
            'total_price' => 'nullable|numeric',
        ]);
        $data = [
            'item_id' => htmlentities($request->item_id),
            'act' => htmlentities($request->act),
            'quantity' => htmlentities($request->quantity),
            'total_price' => htmlentities($request->total_price),
            'created_by' => Auth::user()->id,
        ];
        try {
            DB::beginTransaction();
            $find = InventoryItem::find(htmlentities($request->item_id));
            if(htmlentities($request->act) == 'ADD'){
                $find->count += htmlentities($request->quantity);
            }
            elseif(htmlentities($request->act) == 'REMOVE'){
                $find->count -= htmlentities($request->quantity);
            }
            $find->save();
            $this->inventory->fill($data)->save();
            $request->session()->flash('success', 'Stock submitted successfully.');
            DB::commit();
            return redirect()->route('inventory.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $inventory_info = $this->inventory->find($id);
        if (!$inventory_info) {
            abort(404);
        }
        try {
            $inventory_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'Inventory Item deleted successfully.');
            cache()->forget('app_inventorys');
            return redirect()->route('inventory.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}

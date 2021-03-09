<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryItemController extends Controller
{
    public function __construct(InventoryItem $inventoryItem)
    {
        $this->middleware(['permission:inventory-list|inventory-create|inventory-edit|inventory-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:inventory-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:inventory-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:inventory-delete'], ['only' => ['destroy']]);
        $this->inventoryitem = $inventoryItem;
    }

    protected function getItem($request)
    {
        $query = $this->inventoryitem->orderBy('id','DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title',$keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getItem($request);
        return view('admin/inventoryitem/list', compact('data'));
    }

    public function create(Request $request)
    {
        $inventoryitem_info = null;
        $title = 'Add Inventory Item Type';
        return view('admin/inventoryitem/form', compact('inventoryitem_info', 'title'));
        
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'title' => 'required|string|max:190',
        ]);
        $data = [
            'title' => htmlentities($request->title),
            'image' => $request->image ?? null,
            'created_by' => Auth::user()->id,
        ];
        try {
            $this->inventoryitem->fill($data)->save();
            $request->session()->flash('success', 'Inventory Item created successfully.');
            cache()->forget('app_inventoryitems');
            return redirect()->route('inventoryitem.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $inventoryitem_info = $this->inventoryitem->find($id);
        if (!$inventoryitem_info) {
            abort(404);
        }
        $title = 'Update Inventory Item Type';
        return view('admin/inventoryitem/form', compact('inventoryitem_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $inventoryitem_info = $this->inventoryitem->find($id);
        if (!$inventoryitem_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|max:190',
        ]);
        $data = [
            'title' => htmlentities($request->title),
            'updated_by' => Auth::user()->id,
        ];
        if ($request->image) {
            $data['image'] = $request->image;
        }
        try {
            $inventoryitem_info->fill($data)->save();
            $request->session()->flash('success', 'Inventory Item updated successfully.');
            return redirect()->route('inventoryitem.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $inventoryitem_info = $this->inventoryitem->find($id);
        if (!$inventoryitem_info) {
            abort(404);
        }
        try {
            $inventoryitem_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'Inventory Item deleted successfully.');
            cache()->forget('app_inventoryitems');
            return redirect()->route('inventoryitem.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}

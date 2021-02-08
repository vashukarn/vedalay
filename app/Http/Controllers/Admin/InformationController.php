<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\Information;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    public function __construct(Information $information)
    {
        $this->middleware(['permission:information-list|information-create|information-edit|information-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:information-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:information-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:information-delete'], ['only' => ['destroy']]);
        $this->information = $information;
    }

    protected function getInfo($request)
    {
        $query = $this->information->orderBy('id','DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title',$keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getInfo($request);
        // dd($data);
        return view('admin/informations/list', compact('data'));
    }

    public function create(Request $request)
    {
        $information_info = null;
        $title = 'Add Information Type';
        return view('admin/informations/form', compact('information_info', 'title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'image' => $request->image_name ?? null,
            'features' => $request->features,
            'position' => $request->position,
            'publish_status' => $request->publish_status,
            'created_by' => Auth::user()->id,
        ];

        moveImage($request->image_name, informationimagepath);
        try {
            $this->information->fill($data)->save();
            $request->session()->flash('success', 'Information created successfully.');
            return redirect()->route('information.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $information_info = $this->information->find($id);
        if (!$information_info) {
            abort(404);
        }
        $title = 'Update Information Type';
        return view('admin/informations/form', compact('information_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $information_info = $this->information->find($id);
        if (!$information_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'image' => $request->image_name ?? null,
            'features' => $request->features,
            'position' => $request->position,
            'publish_status' => $request->publish_status,
            'updated_by' => Auth::user()->id,
        ];
        
        moveImage($request->image_name, informationimagepath);
        if ($information_info) {
            $oldImage =  $information_info->image;
            if ($request->image_name != $oldImage) {
                removeImage($oldImage, informationimagepath);
            }
        }

        try {
            $information_info->fill($data)->save();
            $request->session()->flash('success', 'Information updated successfully.');
            return redirect()->route('information.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $information_info = $this->information->find($id);
        if (!$information_info) {
            abort(404);
        }
        try {
            $information_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'Information deleted successfully.');
            return redirect()->route('information.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    public function __construct(Slider $slider)
    {
        $this->middleware(['permission:slider-list|slider-create|slider-edit|slider-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:slider-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:slider-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:slider-delete'], ['only' => ['destroy']]);
        $this->slider = $slider;
    }

    protected function getSlider($request)
    {
        $query = $this->slider->orderBy('id','DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title',$keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getSlider($request);
        return view('admin/sliders/list', compact('data'));
    }

    public function create(Request $request)
    {
        $slider_info = null;
        $title = 'Add Slider Type';
        return view('admin/sliders/form', compact('slider_info', 'title'));
        
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'en_title' => 'required|string|min:3|max:190',
            'np_title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => [
                'en' => htmlentities($request->en_title),
                'np' => htmlentities($request->np_title),
            ],
            'sub_title' => [
                'en' => htmlentities($request->en_sub_title),
                'np' => htmlentities($request->np_sub_title),
            ],
            'description' => [
                'en' => $request->en_description,
                'np' => $request->np_description,
            ],
            'slider_type' => $request->slider_type,
            'external_url' => $request->external_url,
            'position' => $request->position,
            'publish_status' => $request->publish_status,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ];
        if ($request->image) {
            $image = explode("/",$request->image);
            $data['image'] = end($image);
        }
        try {
            $this->slider->fill($data)->save();
            $request->session()->flash('success', 'Slider created successfully.');
            cache()->forget('app_sliders');
            return redirect()->route('slider.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $slider_info = $this->slider->find($id);
        if (!$slider_info) {
            abort(404);
        }
        $title = 'Update Slider Type';
        return view('admin/sliders/form', compact('slider_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $slider_info = $this->slider->find($id);
        if (!$slider_info) {
            abort(404);
        }
        $this->validate($request, [
            'en_title' => 'required|string|min:3|max:190',
            'np_title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => [
                'en' => htmlentities($request->en_title),
                'np' => htmlentities($request->np_title),
            ],
            'sub_title' => [
                'en' => htmlentities($request->en_sub_title),
                'np' => htmlentities($request->np_sub_title),
            ],
            'description' => [
                'en' => $request->en_description,
                'np' => $request->np_description,
            ],

            'slider_type' => $request->slider_type,
            'external_url' => $request->external_url,
            'position' => $request->position,
            'publish_status' => $request->publish_status,
            'updated_by' => Auth::user()->id,
        ];
        if ($request->image) {
            $image = explode("/",$request->image);
            $data['image'] = end($image);
        }
        try {
            $slider_info->fill($data)->save();
            $request->session()->flash('success', 'Slider updated successfully.');
            return redirect()->route('slider.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $slider_info = $this->slider->find($id);
        if (!$slider_info) {
            abort(404);
        }
        try {
            $slider_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'Slider deleted successfully.');
            cache()->forget('app_sliders');
            return redirect()->route('slider.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}

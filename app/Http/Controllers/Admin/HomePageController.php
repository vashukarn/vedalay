<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePage;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function __construct(HomePage $homepage)
    {
        $this->middleware(['permission:slider-list|slider-create|slider-edit|slider-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:slider-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:slider-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:slider-delete'], ['only' => ['destroy']]);
        $this->homepage = $homepage;
    }
    public function index()
    {
        if ($this->homepage) {
            $this->homepage = $this->homepage->orderBy('created_at', 'desc')->first();
        } else {
            $this->homepage = [];
        }
        return view('admin.pages.indexform')->with('page_detail', $this->homepage);
    }

    public function store(Request $request)
    {
        dd($request->all());
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
        ]);
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->contact_no,
            'logo' => $request->logo ?? null,
            'favicon' => $request->favicon ?? null,
            'og_image' => $request->og_image ?? null,
            'is_favicon' => $request->is_favicon,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'skype' => $request->skype,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'meta' => $request->meta,
            'is_meta' => $request->is_meta,
        ];
        try {
            $this->homepage->fill($data)->save();
            $request->session()->flash('success', 'Settings saved successfully.');
            return redirect()->route('setting.index');
        } catch (\Exception $error) {
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
        //
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $homepage = $this->homepage->find($id);
        if (!$homepage) {
            abort(404);
        }
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->contact_no,
            'logo' => $request->logo ?? null,
            'favicon' => $request->favicon ?? null,
            'og_image' => $request->og_image ?? null,
            'is_favicon' => $request->is_favicon,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'skype' => $request->skype,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'meta' => $request->meta,
            'is_meta' => $request->is_meta,
        ];

        try {
            $homepage->fill($data)->save();
            $request->session()->flash('success', 'Settings updated successfully.');
            return redirect()->route('setting.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        //
    }
}

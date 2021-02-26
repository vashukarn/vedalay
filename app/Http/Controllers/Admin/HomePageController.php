<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePage;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function __construct(HomePage $homepage)
    {
        $this->middleware(['permission:homepage-edit'], ['only' => ['index','store', 'update']]);
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
        $data = [
            'topTopics' => $request->topTopics,
            'firstjumbotron' => $request->firstjumbotron,
            'aboutinfo' => $request->aboutinfo,
            'features' => $request->features,
            'threefeatures' => $request->threefeatures,
            'logo' => $request->logo,
        ];
        // dd($data);
        try {
            $this->homepage->fill($data)->save();
            $request->session()->flash('success', 'Home Page Description saved successfully.');
            return redirect()->route('homepage.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $homepage = $this->homepage->find($id);
        if (!$homepage) {
            abort(404);
        }
        $data = [
            'topTopics' => $request->topTopics,
            'firstjumbotron' => $request->firstjumbotron,
            'aboutinfo' => $request->aboutinfo,
            'features' => $request->features,
            'threefeatures' => $request->threefeatures,
            'logo' => $request->logo,
        ];

        try {
            $homepage->fill($data)->save();
            $request->session()->flash('success', 'Home Page Data updated successfully.');
            return redirect()->route('homepage.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

}

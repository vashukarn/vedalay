<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function __construct(Tag $tag)
    {
        $this->get_web();
        $this->middleware(['permission:tag-list|tag-create|tag-edit|tag-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:tag-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:tag-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:tag-delete'], ['only' => ['destroy']]);
        $this->tag = $tag;
    }

    protected function getQuery($request)
    {
        $query = $this->tag->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getQuery($request);
        return view('admin/blogs/tag-list', compact('data'));
    }

    public function create(Request $request)
    {
        $tag_info = null;
        $title = 'Add Tag Type';
        return view('admin/blogs/tag-form', compact('tag_info', 'title'));
    }
    protected function mapTagData($request, $tagInfo = null)
    {
        $data = [
            'title' => [
                'en' => $request->en_title ?? $request->np_title,
                'np' => $request->np_title ?? $request->en_title,
            ],
            'description' => [
                'en' => htmlentities($request->en_description) ?? htmlentities($request->np_description),
                'np' => htmlentities($request->np_description) ?? htmlentities($request->en_description),
            ],
            "slug" => $this->getSlug($request->np_title ?? $$request->en_title ?? $request->title, @$tagInfo->id),
            "publish_status" => $request->publish_status,
            'created_by' => Auth::user()->id,
        ];
        return $data;
    }
    protected function get_validator()
    {
        
        // dd($this->_website);
        if ($this->_website == 'Nepali') {
            return [
                'np_title' => "required|string|max:100",
                "np_description" => "required|string|",
                'publish_status' => "required|numeric|in:1,0",
            ];
        } else if ($this->_website == 'English') {
            return [
                'en_title' => "required|string|max:100",
                'en_description' => "required|string",
                "publish_status" => "required|numeric|in;1,0",
            ];
        } else if ($this->_website == 'Both') {
            return [
                'np_title' => "required|string|max:100",
                "en_title" => "required|string|max:100",
                "np_description" => "required|string|",
                'en_description' => "required|string",
                "publish_status" => "required|numeric|in:1,0",
            ];
        }
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, $this->get_validator());
        $data = $this->mapTagData($request);
        // dd($data);
        try {
            $this->tag->fill($data)->save();
            $request->session()->flash('success', 'Tag created successfully.');
            return redirect()->route('tag.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $tag_info = $this->tag->find($id);
        if (!$tag_info) {
            abort(404);
        }
        $title = 'Update Tag Type';
        return view('admin/blogs/tag-form', compact('tag_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $tag_info = $this->tag->find($id);
        if (!$tag_info) {
            abort(404);
        }
        // dd($this->get_validator());
        $this->validate($request, $this->get_validator());
        $data = $this->mapTagData($request, $tag_info);
        $data['updated_by'] = Auth::user()->id;
        if ($request->image) {
            $image_name = uploadFile($request->image, 'uploads/tags/', false, time());
            // dd($icon);s
            if ($image_name) {
                $data['image'] = $image_name;
                deleteFile(@$tag_info->image, 'uploads/tags', true);
            }
        }

        try {
            $tag_info->fill($data)->save();
            $request->session()->flash('success', 'Tag updated successfully.');
            return redirect()->route('tag.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $tag_info = $this->tag->find($id);
        if (!$tag_info) {
            abort(404);
        }
        try {
            $tag_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'Tag deleted successfully.');
            return redirect()->route('tag.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    protected function getSlug($title)
    {
        $slug = Str::slug($title);
        $find = $this->tag->where('slug', $slug)->first();
        // dd($find);
        if ($find) {
            $slug = $slug . '-' . rand(1111, 9999);
        }
        // dd($slug);
        return $slug;
    }
}

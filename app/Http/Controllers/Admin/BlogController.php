<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function __construct(Blog $blog)
    {
        $this->middleware(['permission:blog-list|blog-create|blog-edit|blog-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:blog-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:blog-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:blog-delete'], ['only' => ['destroy']]);
        $this->blog = $blog;
    }

    protected function getQuery($request)
    {
        $query = $this->blog->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getQuery($request);
        return view('admin/blogs/blog-list', compact('data'));
    }

    public function create(Request $request)
    {
        $blog_info = null;
        $title = 'Add Blog';
        $data = [
            'blog_info' => $blog_info,
            'title' => $title,
        ];
        return view('admin/blogs/blog-form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'short_description' => 'required',
            'description' => 'required',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'image' => $request->image ?? null,
            'external_url' => $request->external_url,
            'publish_status' => $request->publish_status,
            'created_by' => Auth::user()->id,
        ];
        try {
            $this->blog->fill($data)->save();
            $request->session()->flash('success', 'Blog created successfully.');
            return redirect()->route('blog.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $blog_info = $this->blog->find($id);
        if (!$blog_info) {
            abort(404);
        }
        $title = 'Update Blog';
        $data = [
            'blog_info' => $blog_info,
            'title' => $title,
        ];
        return view('admin/blogs/blog-form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $blog_info = $this->blog->find($id);
        if (!$blog_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'short_description' => 'required',
            'description' => 'required',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'external_url' => $request->external_url,
            'publish_status' => $request->publish_status,
            'updated_by' => Auth::user()->id,
        ];
        if ($request->image) {
            $data['image'] = $request->image;
        }
        try {
            $blog_info->fill($data)->save();
            $request->session()->flash('success', 'Blog updated successfully.');
            return redirect()->route('blog.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $blog_info = $this->blog->find($id);
        if (!$blog_info) {
            abort(404);
        }
        try {
            $blog_info->updated_by = Auth::user()->id;
            $blog_info->save();
            $blog_info->delete();
            $request->session()->flash('success', 'Blog deleted successfully.');
            return redirect()->route('blog.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}

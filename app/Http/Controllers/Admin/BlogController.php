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
        $this->middleware(['permission:blog-list|blog-create|blog-edit|blog-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:blog-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:blog-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:blog-delete'], ['only' => ['destroy']]);
        $this->blog = $blog;
    }

    protected function getQuery($request)
    {
        $query = $this->blog->orderBy('id','DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title',$keyword);
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
        $title = 'Add Blog Type';
        return view('admin/blogs/blog-form', compact('blog_info', 'title', 'tags'));
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
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'excerpt' => $request->excerpt,
            'description' => $request->description,
            'external_url' => $request->external_url,
            'publish_status' => $request->publish_status
        ];
        $data['created_by'] = Auth::user()->id;
        if ($request->featured_img) {
            $image_name = uploadFile($request->featured_img, 'uploads/blogs/', false, time());
            // dd($icon);
            if ($image_name) {
                $data['featured_img'] = $image_name;
            }
        }
        if ($request->parallex_img) {
            $image_name = uploadFile($request->parallex_img, 'uploads/blogs/', false, time());
            // dd($icon);
            if ($image_name) {
                $data['parallex_img'] = $image_name;
            }
        }
        try {
            $this->blog->fill($data)->save();

            $this->blog->tags()->attach(request('tag_id'));
            $this->blog->categories()->attach(request('category_id'));

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
        $title = 'Update Blog Type';
        $selectedtags = $blog_info->tags->pluck('id');
        $tags = Tag::status()->pluck('title','id');
        $selectedcategories = $blog_info->categories->pluck('id');
        // dd($selectedtags);
        $categories = Category::status()->pluck('title','id');
        return view('admin/blogs/blog-form', compact('blog_info', 'title', 'tags', 'categories', 'selectedtags', 'selectedcategories'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $blog_info = $this->blog->find($id);
        if (!$blog_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'external_url' => $request->external_url,
            'publish_status' => $request->publish_status
        ];
        $data['updated_by'] = Auth::user()->id;
        if ($request->featured_img) {
            $image_name = uploadFile($request->featured_img, 'uploads/blogs/', false, time());
            // dd($icon);
            if ($image_name) {
                $data['featured_img'] = $image_name;
                deleteFile(@$blog_info->featured_img, 'uploads/blogs', true);
            }
        }

        if ($request->parallex_img) {
            $image_name = uploadFile($request->parallex_img, 'uploads/blogs/', false, time());
            // dd($icon);
            if ($image_name) {
                $data['parallex_img'] = $image_name;
                deleteFile(@$blog_info->parallex_img, 'uploads/blogs', true);
            }
        }

        try {
            $blog_info->fill($data)->save();
            $blog_info->tags()->sync(request('tag_id'));
            $blog_info->categories()->sync(request('category_id'));
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
            $blog_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'Blog deleted successfully.');
            return redirect()->route('blog.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}

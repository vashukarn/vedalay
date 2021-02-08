<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\News;
use App\Models\Menu;
use Illuminate\Http\Request;
use Str;

class NewsController extends Controller
{

    public function __construct(News $news)
    {
        $this->get_web();
        $this->news = $news;
    }

    public function index(Request $request)
    {
        $limit = 20;
        if ($request->limit && $request->limit > 0 && $request->limit < 150) {
            $limit = $request->limit;
        }

        $news = $this->news->paginate($limit);
        $news->appends($request->all());
        $data = [
            'news' => $news,
            'pageTitle' => "News",
        ];
        return view('admin/news/news-list', $data);
    }

    public function create(Request $request)
    {

        $news_category = Menu::where('slug', 'category')
            ->where('publish_status', '1')
            ->orderBy('title')
            ->pluck('title', 'id');
        // dd($news_category);
        $data = [
            'newsInfo' => null,
            'pageTitle' => 'Add News',
            "news_category" => $news_category
        ];
        return view('admin/news/news-create', $data);
    }
    protected function newsValidate($newsInfo = null)
    {
        if($this->_website == 'Nepali' || $this->_website == 'Both'){
            dd('sdfdfsdf');
        }
        $data = [
            "np_title" => "required|string|max:200",
            "en_title" => "nullable|string|max:200",
            "np_description" => "required|string",
            "en_description" => "nullable|string",
            "publish_status" => "required|in:0,1",
            "image_name" => "nullable|string",
            "meta_title" => "nullable|string|max:300",
            "meta_description" => "nullable|string|max:300",
            "meta_keyword" => "nullable|string|max:300",
            "meta_keyphrase" => "nullable|string|max:300",
        ];
        if ($newsInfo) {
            // $data[''] =
        }
        return $data;
    }
    protected function mapNewsData($request, $newsInfo = null)
    {
        $data = [
            "title" => [
                "np" => $request->np_title ?? $request->en_title,
                "en" => $request->en_title ?? $request->np_title,
            ],
            "description" => [
                'np' => htmlentities($request->np_description) ?? htmlentities($request->en_description),
                'en' => htmlentities($request->en_description) ?? htmlentities($request->np_description),
            ],
            "summary" => [
                'en' => htmlentities($request->en_summary) ?? htmlentities($request->np_summary),
                'np' => htmlentities($request->np_summary) ?? htmlentities($request->en_summary),
            ],

            "pubilsh_status" => $request->publish_status ?? '0',
            "meta_title" => htmlentities($request->meta_title) ?? null,
            "meta_description" => htmlentities($request->meta_description) ?? null,
            "meta_keyword" => htmlentities($request->meta_keyword) ?? null,
            "meta_keyphrase" => htmlentities($request->meta_keyphrase) ?? null,
            "category" => $request->category,
            'tags' => $request->tags ,
            // "reporter" => 
        ];
        // dd($request->all());
        if ($request->filepath && !empty($request->filepath)) {
            $image = getImageFromUrl($request->filepath);
            $data['thumbnail'] = $image['image'];
            $data['path'] = $image['path'];
        }
        return $data;
    }

    public function store(Request $request)
    {
        
        try {
            $this->validate($request, $this->newsValidate());
            $data = $this->mapNewsData($request);
            $data['slug'] = $this->getSlug($request->np_title);
            $this->news->fill($data)->save();
            $request->session()->flash('success', 'News created successfully.');
            return redirect()->route('news.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->to(url()->previous());
        }
    }
    public function edit(Request $request, $id)
    {
        $newsInfo = $this->news->find($id);

        if (!$newsInfo) {
            $request->session()->flash('error', 'News information not found.');
            return redirect()->route('news.index');
        }
        $newsInfo->image_url = getFullImage($newsInfo->thumbnail, $newsInfo->path);
        $newsInfo->image_thumb_url = getThumbImage($newsInfo->thumbnail, $newsInfo->path);
        $news_category = Menu::where('slug', 'category')
            ->where('publish_status', '1')
            ->orderBy('title')
            ->pluck('title', 'id');

        $data = [
            'newsInfo' => $newsInfo,
            "pageTitle" => "Update News",
            "news_category" => $news_category
        ];
        return view('admin/news/news-create', $data);
    }
    public function update(Request $request, $id)
    {
        $newsInfo = $this->news->find($id);

        if (!$newsInfo) {
            $request->session()->flash('error', 'News information not found.');
            return redirect()->route('news.index');
        }

        try {
            $this->validate($request, $this->newsValidate());
            $data = $this->mapNewsData($request);
            $newsInfo->fill($data)->save();
            $request->session()->flash('success', 'News updated successfully.');
            return redirect()->route('news.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->to(url()->previous());
        }
    }
    protected function getSlug($title)
    {
        $slug = Str::slug($title);
        $find = $this->news->where('slug', $slug)->first();
        if ($find) {
            $slug = $slug . '-' . rand(1111, 9999);
        }
        return $slug;
    }
}

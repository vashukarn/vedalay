<?php
namespace App\Http\View\Composers;
use App\Models\AppSetting;
use App\Models\Blog;
use App\Models\HomePage;
use App\Models\Menu;
use Illuminate\View\View;
class MenuComposer
{
    public function compose(View $view)
    {
        $menus = Menu::where('publish_status', 'active')->orderBy('position', 'ASC')->where('parent_id', null)->get();
        $pagedata = HomePage::latest()->first();
        $sitesetting = AppSetting::orderBy('created_at', 'desc')->first();
        $blogs = Blog::where('publish_status', '1')->orderBy('id', 'DESC')->limit(5)->get();
        $view->with([
            'sitesetting' => $sitesetting,
            'blogs' => $blogs,
            'page' => $pagedata,
        ]);
    }
}
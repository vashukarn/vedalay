<?php
namespace App\Http\View\Composers;
use App\Models\AppSetting;
use App\Models\Menu;
use Illuminate\View\View;
class MenuComposer
{
    public function compose(View $view)
    {
        $menus = Menu::where('publish_status', 'active')->orderBy('position', 'ASC')->where('parent_id', null)->get();
        $sitesetting = AppSetting::orderBy('created_at', 'desc')->first();
        $view->with([
            'menus' => $menus,
            'sitesetting' => $sitesetting,
        ]);
    }
}
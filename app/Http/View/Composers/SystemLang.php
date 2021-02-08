<?php
namespace App\Http\View\Composers;

use App\Models\AppSetting;
use Illuminate\View\View;

class SystemLang
{
    public function compose(View $view)
    {
        $_website = session()->get('_website');
        $app_content = session()->get('website_content_item');
        if (!$_website) {
            $website = AppSetting::select('website_content_format')->orderBy('created_at', 'desc')->first();
            $_website = @$website->website_content_format;
            session()->put('_website',$_website );
        }
        if(!$app_content){
            $website = AppSetting::select(  'website_content_item')->orderBy('created_at', 'desc')->first();
            session()->put('website_content_item',$website->website_content_item);
            $app_content = @$website->website_content_item; 
           
        }
        
         
        // dd($_website);
        $view->with([
            '_website' => $_website,
            'app_content' => $app_content,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public $_website;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
    }
    public function get_web()
    {
        // dd('dsfsdfsdf');
      $_website =  session()->get('_website');
        if (!$_website) {
            $website = AppSetting::select('website_content_format')->orderBy('created_at', 'desc')->first();
            $_website = @$website->website_content_format;
            session()->put('_website',$_website );
        }
    $this->_website = $_website;
    }
}

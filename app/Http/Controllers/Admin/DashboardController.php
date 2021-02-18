<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Information;
use App\Models\Slider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {

    }

    public function index(){
        
        $count_data['admin'] = User::where('type', 'admin')->where('publish_status', '1')->count();
        $count_data['staff'] = User::where('type', 'staff')->where('publish_status', '1')->count();
        $count_data['user'] = User::where('type', 'user')->where('publish_status', '1')->count();
        $count_data['slider'] = Slider::where('publish_status', '1')->count();
        $count_data['information'] = Information::where('publish_status', '1')->count();
        $count_data['feature'] = Feature::where('publish_status', '1')->count();
        
        $data = [
            'count_data' => $count_data,
        ];

        return view('admin.dashboard')->with($data);
    }

}

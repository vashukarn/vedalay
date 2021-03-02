<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Fee;
use App\Models\HomePage;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function mail()
    {
        $fee = Fee::select('title', 'tuition_fee', 'exam_fee', 'transport_fee',
         'stationery_fee', 'sports_fee', 'club_fee', 'hostel_fee', 'laundry_fee', 
         'education_tax', 'eca_fee', 'late_fine', 'extra_fee', 'total_amount')->first();
        $student = User::select('name')->first();
        $data = [
            'student_info' => $student,
            'fee_info' => $fee,
        ];
        return view('mail.feeadd')->with($data);
    }
    public function home()
    {
        $sliders = Slider::where('publish_status', '1')->get();
        $pagedata = HomePage::latest()->first();
        $features = Feature::where('publish_status', '1')->get();
        $team = Team::where('publish_status', '1')->get();
        $testimonials = Testimonial::where('publish_status', '1')->orderBy('position', 'DESC')->get();
        $faqs = Faq::where('publish_status', '1')->orderBy('position', 'DESC')->get();
        $blogs = Blog::where('publish_status', '1')->orderBy('id', 'DESC')->limit(3)->get();
        $sitesetting = AppSetting::orderBy('created_at', 'desc')->first();
        $data = [
            'sliders' => $sliders,
            'page' => $pagedata,
            'features' => $features,
            'team' => $team,
            'testimonials' => $testimonials,
            'faqs' => $faqs,
            'blogs' => $blogs,
            'sitesetting' => $sitesetting,
        ];
        return view('website.index')->with($data);
    }

    public function contactStore(Request $request)
    {
        // dd($request->all());
        $error = null;
        try {
            $result = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->comments,
            ]);
            $data = $result;

        } catch (\Exception $e) {
            $data = $e;
        }

        return response()->json($data);
    }

    public function blogs()
    {
        $blogs = Blog::where('publish_status', '1')->paginate(3);
        $meta = AppSetting::orderBy('created_at', 'desc')->first();
        return view('website.blogs', compact('blogs', 'categories', 'tags', 'pagedata', 'meta'));
    }

    public function blogdetail($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        $recentblog = Blog::where('slug', $slug)->orderBy('id', 'DESC')->limit(3)->get();
        $data = [
            'blog' => $blog,
        ];
        return view('website.blogdetail')->with($data);
    }
    
    
    // public function page($pagedata = null)
    // {
    //     if ($pagedata != null) {
    //         $pagevalue = @$pagedata->content_type;
    //         switch ($pagevalue) {
    //             case 'about':
    //                 $meta = AppSetting::orderBy('created_at', 'desc')->first();
    //                 return view('website.about', compact('cities', 'pagedata', 'meta'));
    //                 break;
    //             // case 'faqs':
    //             //     $faqs = Faq::where('publish_status', '1')->orderBy('position', 'ASC')->get();
    //             //     $meta = AppSetting::orderBy('created_at', 'desc')->first();
    //             //     if($meta != null){
    //             //         $meta->meta_title = @$pagedata->meta_title;
    //             //         $meta->meta_keyword = @$pagedata->meta_keyword;
    //             //         $meta->meta_description = @$pagedata->meta_description;
    //             //     }
    //             //     $usercount = User::count();
    //             //     return view('website.faqs', compact('faqs', 'pagedata', 'meta', 'usercount'));
    //             //     break;
    //             case 'contact':
    //                 $result['setting'] = AppSetting::orderBy('created_at', 'desc')->first();
    //                 $meta = AppSetting::orderBy('created_at', 'desc')->first();
    //                 if ($meta != null) {
    //                     $meta->meta_title = @$pagedata->meta_title;
    //                     $meta->meta_keyword = @$pagedata->meta_keyword;
    //                     $meta->meta_description = @$pagedata->meta_description;
    //                 }
    //                 return view('website.contact', compact('result', 'pagedata', 'meta'));
    //                 break;
    //             case 'blogs':
    //                 $blogs = Blog::where('publish_status', '1')->paginate(3);
    //                 $categories = Category::where('publish_status', '1')->get();
    //                 $tags = Tag::where('publish_status', '1')->orderBy('position', 'ASC')->get();
    //                 $meta = AppSetting::orderBy('created_at', 'desc')->first();
    //                 if ($meta != null) {
    //                     $meta->meta_title = @$pagedata->meta_title;
    //                     $meta->meta_keyword = @$pagedata->meta_keyword;
    //                     $meta->meta_description = @$pagedata->meta_description;
    //                 }
    //                 return view('website.blogs', compact('blogs', 'categories', 'tags', 'pagedata', 'meta'));
    //                 break;
    //             case 'basicpage':
    //                 $meta = AppSetting::orderBy('created_at', 'desc')->first();
    //                 if ($meta != null) {
    //                     $meta->meta_title = @$pagedata->meta_title;
    //                     $meta->meta_keyword = @$pagedata->meta_keyword;
    //                     $meta->meta_description = @$pagedata->meta_description;
    //                 }
    //                 return view('website.basicpage', compact('pagedata', 'meta'));
    //                 break;
    //             default:
    //                 return redirect()->route('index');
    //                 break;
    //         }
    //     } else {
    //         return redirect()->route('index');
    //     }
    // }


}

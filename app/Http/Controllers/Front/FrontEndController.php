<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Contact;
use App\Models\HomePage;
use App\Models\Slider;
use App\Models\Tag;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function home()
    {
        $sliders = Slider::where('publish_status', '1')->get();
        $pagedata = HomePage::latest()->first();
        // dd($pagedata);
        $data = [
            'sliders' => $sliders,
            'page' => $pagedata,
        ];
        return view('website.index')->with($data);
    }
    public function register()
    {
        $meta = AppSetting::orderBy('created_at', 'desc')->first();
        if ($meta != null) {
            $meta->meta_title = @$pagedata->meta_title;
            $meta->meta_keyword = @$pagedata->meta_keyword;
            $meta->meta_description = @$pagedata->meta_description;
        }
        return view('website.register', compact('meta', 'pagedata', 'vehicle_type'));
    }
    public function page($pagedata = null)
    {
        if ($pagedata != null) {
            $pagevalue = @$pagedata->content_type;
            switch ($pagevalue) {
                case 'about':
                    $meta = AppSetting::orderBy('created_at', 'desc')->first();
                    return view('website.about', compact('cities', 'pagedata', 'meta'));
                    break;
                // case 'faqs':
                //     $faqs = Faq::where('publish_status', '1')->orderBy('position', 'ASC')->get();
                //     $meta = AppSetting::orderBy('created_at', 'desc')->first();
                //     if($meta != null){
                //         $meta->meta_title = @$pagedata->meta_title;
                //         $meta->meta_keyword = @$pagedata->meta_keyword;
                //         $meta->meta_description = @$pagedata->meta_description;
                //     }
                //     $usercount = User::count();
                //     return view('website.faqs', compact('faqs', 'pagedata', 'meta', 'usercount'));
                //     break;
                case 'contact':
                    $result['setting'] = AppSetting::orderBy('created_at', 'desc')->first();
                    $meta = AppSetting::orderBy('created_at', 'desc')->first();
                    if ($meta != null) {
                        $meta->meta_title = @$pagedata->meta_title;
                        $meta->meta_keyword = @$pagedata->meta_keyword;
                        $meta->meta_description = @$pagedata->meta_description;
                    }
                    return view('website.contact', compact('result', 'pagedata', 'meta'));
                    break;
                case 'blogs':
                    $blogs = Blog::where('publish_status', '1')->paginate(3);
                    $categories = Category::where('publish_status', '1')->get();
                    $tags = Tag::where('publish_status', '1')->orderBy('position', 'ASC')->get();
                    $meta = AppSetting::orderBy('created_at', 'desc')->first();
                    if ($meta != null) {
                        $meta->meta_title = @$pagedata->meta_title;
                        $meta->meta_keyword = @$pagedata->meta_keyword;
                        $meta->meta_description = @$pagedata->meta_description;
                    }
                    return view('website.blogs', compact('blogs', 'categories', 'tags', 'pagedata', 'meta'));
                    break;
                case 'basicpage':
                    $meta = AppSetting::orderBy('created_at', 'desc')->first();
                    if ($meta != null) {
                        $meta->meta_title = @$pagedata->meta_title;
                        $meta->meta_keyword = @$pagedata->meta_keyword;
                        $meta->meta_description = @$pagedata->meta_description;
                    }
                    return view('website.basicpage', compact('pagedata', 'meta'));
                    break;
                default:
                    return redirect()->route('index');
                    break;
            }
        } else {
            return redirect()->route('index');
        }
    }

    public function contactStore(Request $request)
    {
        $error = null;
        try {
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->phone = $request->phone;
            $contact->message = $request->message;

            $contact->save();
        } catch (\Exception $e) {
            $error = $e;
        }

        return response()->json(['success' => 'Submitted Successfully!', 'error' => $error]);
    }
    // public function featureDetail($slug)
    // {
    //     $feature = Feature::where('slug', $slug)->first();
    //     $meta = AppSetting::orderBy('created_at', 'desc')->first();
    //     return view('website.featuredetail', compact('feature', 'meta'));
    // }

    public function blogs()
    {
        $blogs = Blog::where('publish_status', '1')->paginate(3);
        $categories = Category::where('publish_status', '1')->get();
        $tags = Tag::where('publish_status', '1')->orderBy('position', 'ASC')->get();
        $meta = AppSetting::orderBy('created_at', 'desc')->first();
        if ($meta != null) {
            $meta->meta_title = @$pagedata->meta_title;
            $meta->meta_keyword = @$pagedata->meta_keyword;
            $meta->meta_description = @$pagedata->meta_description;
        }
        return view('website.blogs', compact('blogs', 'categories', 'tags', 'pagedata', 'meta'));
    }

    public function blogdetail($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        $recentblog = Blog::where('slug', $slug)->orderBy('id', 'DESC')->limit(3)->get();
        $categories = Category::where('publish_status', '1')->get();
        $tags = Tag::where('publish_status', '1')->orderBy('position', 'ASC')->get();
        $meta = AppSetting::orderBy('created_at', 'desc')->first();
        if ($meta != null) {
            $meta->meta_title = @$blog->meta_title;
            $meta->meta_keyword = @$blog->meta_keyword;
            $meta->meta_description = @$blog->meta_description;
        }
        return view('website.blogdetail', compact('blog', 'recentblog', 'categories', 'tags'));
    }

    public function basicpage()
    {
        return view('website.basicpage');
    }

    // public function registeruser(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|max:255',
    //         'mobile' => 'required|unique:users|digits:10',
    //         'password' => 'required|same:confirmpassword|min:6',
    //     ]);
    //     $user =  new User();
    //     $user->name = $request->name;
    //     $user->mobile = $request->mobile;
    //     $user->type = "rider";
    //     $user->password = Hash::make($request->password);
    //     $user->save();
    //     $rider->user_id = $user->id;
    //     $data = [];
    //     $rider->documents = $this->mapDocument($request, $data);
    //     $rider->vehicle_info = $this->mapVehicleData($request, $data);
    //     $rider->save();
    //     Session::flash('success', 'User Created Successfully.');
    //     return redirect()->route('index');
    // }

}

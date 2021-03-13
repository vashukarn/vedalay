<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function __construct(HomePage $homepage)
    {
        $this->middleware(['permission:homepage-edit'], ['only' => ['index','store', 'update']]);
        $this->homepage = $homepage;
    }
    public function index()
    {
        if ($this->homepage) {
            $this->homepage = $this->homepage->orderBy('created_at', 'desc')->first();
        } else {
            $this->homepage = [];
        }
        return view('admin.pages.indexform')->with('page_detail', $this->homepage);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = [
            'landing_title1' => $request->landing_title1,
            'landing_title2' => $request->landing_title2,
            'landing_title3' => $request->landing_title3,
            'landing_subtitle' => $request->landing_subtitle,
            'landing_image' => $request->landing_image,
            'customers_title1' => $request->customers_title1,
            'customers_title2' => $request->customers_title2,
            'customers_title3' => $request->customers_title3,
            'customers_subtitle' => $request->customers_subtitle,
            'customers_logo1' => $request->customers_logo1,
            'customers_logo2' => $request->customers_logo2,
            'customers_logo3' => $request->customers_logo3,
            'whyus_title' => $request->whyus_title,
            'whyus_subtitle' => $request->whyus_subtitle,
            'whyus_paragraph' => $request->whyus_paragraph,
            'whyus_features' => $request->whyus_features,
            'whyus_image' => $request->whyus_image,
            'whyus_link' => $request->whyus_link,
            'features_title' => $request->features_title,
            'features_subtitle' => $request->features_subtitle,
            'features_image' => $request->features_image,
            'newsletter_title' => $request->newsletter_title,
            'newsletter_subtitle' => $request->newsletter_subtitle,
            'newsletter_counters' => $request->newsletter_counters,
            'newsletter_image' => $request->newsletter_image,
            'work_title' => $request->work_title,
            'work_subtitle' => $request->work_subtitle,
            'work_detail' => $request->work_detail,
            'priceplan_title' => $request->priceplan_title,
            'priceplan_subtitle' => $request->priceplan_subtitle,
            'team_title' => $request->team_title,
            'team_subtitle' => $request->team_subtitle,
            'review_title' => $request->review_title,
            'review_subtitle' => $request->review_subtitle,
            'faq_title' => $request->faq_title,
            'faq_subtitle' => $request->faq_subtitle,
            'faq_image' => $request->faq_image,
            'faq_link' => $request->faq_link,
            'blog_title' => $request->blog_title,
            'blog_subtitle' => $request->blog_subtitle,
            'parallax_title' => $request->parallax_title,
            'parallax_subtitle' => $request->parallax_subtitle,
            'parallax_image' => $request->parallax_image,
            'contact_title' => $request->contact_title,
            'contact_subtitle' => $request->contact_subtitle,
            'contact_form_title' => $request->contact_form_title,
            'map_link' => $request->map_link,
            'footer_company_subtitle' => $request->footer_company_subtitle,
            'footer_contact_subtitle' => $request->footer_contact_subtitle,
            'created_by' => Auth::user()->id,
        ];
            

        try {
            $this->homepage->fill($data)->save();
            $request->session()->flash('success', 'Home Page data saved successfully.');
            return redirect()->route('homepage.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $homepage = $this->homepage->find($id);
        if (!$homepage) {
            abort(404);
        }
        $data = [
            'landing_title1' => $request->landing_title1,
            'landing_title2' => $request->landing_title2,
            'landing_title3' => $request->landing_title3,
            'landing_subtitle' => $request->landing_subtitle,
            'customers_title1' => $request->customers_title1,
            'customers_title2' => $request->customers_title2,
            'customers_title3' => $request->customers_title3,
            'customers_subtitle' => $request->customers_subtitle,
            'whyus_title' => $request->whyus_title,
            'whyus_subtitle' => $request->whyus_subtitle,
            'whyus_paragraph' => $request->whyus_paragraph,
            'whyus_features' => $request->whyus_features,
            'whyus_link' => $request->whyus_link,
            'features_title' => $request->features_title,
            'features_subtitle' => $request->features_subtitle,
            'features_image' => $request->features_image,
            'newsletter_title' => $request->newsletter_title,
            'newsletter_subtitle' => $request->newsletter_subtitle,
            'newsletter_counters' => $request->newsletter_counters,
            'work_title' => $request->work_title,
            'work_subtitle' => $request->work_subtitle,
            'priceplan_title' => $request->priceplan_title,
            'priceplan_subtitle' => $request->priceplan_subtitle,
            'team_title' => $request->team_title,
            'team_subtitle' => $request->team_subtitle,
            'review_title' => $request->review_title,
            'review_subtitle' => $request->review_subtitle,
            'faq_title' => $request->faq_title,
            'faq_subtitle' => $request->faq_subtitle,
            'faq_image' => $request->faq_image,
            'faq_link' => $request->faq_link,
            'blog_title' => $request->blog_title,
            'blog_subtitle' => $request->blog_subtitle,
            'parallax_title' => $request->parallax_title,
            'parallax_subtitle' => $request->parallax_subtitle,
            'parallax_image' => $request->parallax_image,
            'contact_title' => $request->contact_title,
            'contact_subtitle' => $request->contact_subtitle,
            'contact_form_title' => $request->contact_form_title,
            'map_link' => $request->map_link,
            'footer_company_subtitle' => $request->footer_company_subtitle,
            'footer_contact_subtitle' => $request->footer_contact_subtitle,
            'updated_by' => Auth::user()->id,
        ];
        if($request->landing_image){
            $data['landing_image'] = $request->landing_image;
        }
        if($request->customers_logo1){
            $data['customers_logo1'] = $request->customers_logo1;
        }
        if($request->customers_logo2){
            $data['customers_logo2'] = $request->customers_logo2;
        }
        if($request->customers_logo3){
            $data['customers_logo3'] = $request->customers_logo3;
        }
        if($request->whyus_image){
            $data['whyus_image'] = $request->whyus_image;
        }
        if($request->features_image){
            $data['features_image'] = $request->features_image;
        }
        if($request->newsletter_image){
            $data['newsletter_image'] = $request->newsletter_image;
        }
         foreach($request->work_detail as $key => $value) {
             if(isset($value['image'])){
                 $data['work_detail'][$key]['image'] = $value['image'];
             }
         }
        try {
            $homepage->fill($data)->save();
            $request->session()->flash('success', 'Home Page Data updated successfully.');
            return redirect()->route('homepage.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

}

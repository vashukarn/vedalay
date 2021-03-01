<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomePage extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'landing_title1',
        'landing_title2',
        'landing_title3',
        'landing_subtitle',
        'landing_image',
        'customers_title1',
        'customers_title2',
        'customers_title3',
        'customers_subtitle',
        'customers_logo1',
        'customers_logo2',
        'customers_logo3',
        'whyus_title',
        'whyus_subtitle',
        'whyus_paragraph',
        'whyus_features',
        'features_title',
        'features_subtitle',
        'features_image',
        'newsletter_title',
        'newsletter_subtitle',
        'newsletter_counters',
        'work_title',
        'work_subtitle',
        'work_detail',
        'priceplan_title',
        'priceplan_subtitle',
        'team_title',
        'team_subtitle',
        'review_title',
        'review_subtitle',
        'faq_title',
        'faq_subtitle',
        'faq_image',
        'faq_link',
        'blog_title',
        'blog_subtitle',
        'parallax_title',
        'parallax_subtitle',
        'parallax_image',
        'contact_title',
        'contact_subtitle',
        'contact_form_title',
        'map_link',
        'footer_company_subtitle',
        'footer_contact_subtitle',
        'created_by',
        'updated_by',
    ];
    protected $dates = ['deleted_at'];
    protected $casts  = [
        'whyus_features' => 'json',
        'newsletter_counters' => 'json',
        'work_detail' => 'json',
    ];
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    public function updater()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}

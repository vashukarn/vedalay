<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomePagesTable extends Migration
{
    public function up()
    {
        Schema::create('home_pages', function (Blueprint $table) {
            $table->id();
            $table->string('landing_title1')->nullable();
            $table->string('landing_title2')->nullable();
            $table->string('landing_title3')->nullable();
            $table->string('landing_subtitle')->nullable();
            $table->string('landing_image')->nullable();
            $table->string('customers_title1')->nullable();
            $table->string('customers_title2')->nullable();
            $table->string('customers_title3')->nullable();
            $table->string('customers_subtitle')->nullable();
            $table->string('customers_logo1')->nullable();
            $table->string('customers_logo2')->nullable();
            $table->string('customers_logo3')->nullable();
            $table->string('whyus_title')->nullable();
            $table->string('whyus_subtitle')->nullable();
            $table->string('whyus_paragraph')->nullable();
            $table->text('whyus_features')->nullable();
            $table->string('features_title')->nullable();
            $table->string('features_subtitle')->nullable();
            $table->string('features_image')->nullable();
            $table->string('newsletter_title')->nullable();
            $table->string('newsletter_subtitle')->nullable();
            $table->text('newsletter_counters')->nullable();
            $table->string('work_title')->nullable();
            $table->string('work_subtitle')->nullable();
            $table->text('work_detail')->nullable();
            $table->string('priceplan_title')->nullable();
            $table->string('priceplan_subtitle')->nullable();
            $table->string('team_title')->nullable();
            $table->string('team_subtitle')->nullable();
            $table->string('review_title')->nullable();
            $table->string('review_subtitle')->nullable();
            $table->string('faq_title')->nullable();
            $table->string('faq_subtitle')->nullable();
            $table->string('faq_image')->nullable();
            $table->string('faq_link')->nullable();
            $table->string('blog_title')->nullable();
            $table->string('blog_subtitle')->nullable();
            $table->string('parallax_title')->nullable();
            $table->string('parallax_subtitle')->nullable();
            $table->string('parallax_image')->nullable();
            $table->string('contact_title')->nullable();
            $table->string('contact_subtitle')->nullable();
            $table->string('contact_form_title')->nullable();
            $table->string('map_link')->nullable();
            $table->string('footer_company_subtitle')->nullable();
            $table->string('footer_contact_subtitle')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('home_pages');
    }
}

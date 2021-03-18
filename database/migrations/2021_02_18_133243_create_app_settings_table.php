<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->string('is_favicon')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('skype')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('is_meta')->nullable();
            $table->longText('meta')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_light')->nullable();
            $table->string('favicon')->nullable();
            $table->string('og_image')->nullable();
            $table->unsignedBigInteger('current_session')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('current_session')->references('id')->on('sessions')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('app_settings');
    }
}

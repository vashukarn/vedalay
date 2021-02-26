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
            // $table->longText('topTopics')->nullable();
            $table->longText('firstjumbotron')->nullable();
            $table->longText('aboutinfo')->nullable();
            $table->longText('features')->nullable();
            $table->longText('threefeatures')->nullable();
            $table->longText('logo')->nullable();
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

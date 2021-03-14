<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}

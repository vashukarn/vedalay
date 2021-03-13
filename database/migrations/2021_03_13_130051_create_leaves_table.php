<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('from_date')->nullable();
            $table->string('to_date')->nullable();
            $table->string('image')->nullable();
            $table->string('type')->nullable();
            $table->longText('description')->nullable();
            $table->integer('days')->nullable();
            $table->enum('status',['PENDING','ACCEPTED','DECLINED'])->default('PENDING');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('verified_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}

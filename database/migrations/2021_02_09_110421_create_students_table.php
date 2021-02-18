<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id')->references('id')->on('levels')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('session')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('caste_category')->nullable();
            $table->enum('disability',['0','1'])->default('0');
            $table->string('aadhar_number')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('phone')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('current_address')->nullable();
            $table->enum('gender',['male','female','others'])->default('male');
            $table->string('image')->nullable();
            $table->string('fathername')->nullable();
            $table->string('fatheroccupation')->nullable();
            $table->string('fatherincome')->nullable();
            $table->string('mothername')->nullable();
            $table->string('motheroccupation')->nullable();
            $table->string('motherincome')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('last_schoolname')->nullable();
            $table->string('last_level')->nullable();
            $table->string('last_marks')->nullable();
            $table->string('last_state')->nullable();
            $table->string('last_city')->nullable();
            $table->string('transfer_certificate')->nullable();
            $table->string('character_certificate')->nullable();
            $table->string('medical_certificate')->nullable();
            $table->string('undertaking')->nullable();
            $table->string('migration_certificate')->nullable();
            $table->string('last_marksheet')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admissions');
    }
}

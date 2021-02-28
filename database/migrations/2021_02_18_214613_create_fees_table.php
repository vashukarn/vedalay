<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('unique')->nullable();
            $table->string('tuition_fee')->nullable();
            $table->string('exam_fee')->nullable();
            $table->string('transport_fee')->nullable();
            $table->string('stationery_fee')->nullable();
            $table->string('sports_fee')->nullable();
            $table->string('club_fee')->nullable();
            $table->string('hostel_fee')->nullable();
            $table->string('laundry_fee')->nullable();
            $table->string('education_tax')->nullable();
            $table->string('eca_fee')->nullable();
            $table->string('late_fine')->nullable();
            $table->string('extra_fee')->nullable();
            $table->string('total_amount')->nullable();
            $table->enum('rollback',['1','0'])->default(0);
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->string('added_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('student_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('level_id')->references('id')->on('levels')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fees');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->longText('marks')->nullable();
            $table->longText('backlogs')->nullable();
            $table->integer('total_marks')->nullable();
            $table->integer('percentage')->nullable();
            $table->integer('marks_obtained')->nullable();
            $table->string('grade')->nullable();
            $table->integer('sgpa')->nullable();
            $table->enum('gper',['Grade','Percentage'])->default('Percentage');
            $table->enum('status',['PASS','FAIL','WITHHELD'])->default('WITHHELD');
            $table->string('withheld_reason')->nullable();
            $table->enum('publish_status',['1','0'])->default(0);
            $table->unsignedBigInteger('exam_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('session')->nullable();
            $table->foreign('session')->references('id')->on('sessions')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('exam_id')->references('id')->on('exams')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('student_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('level_id')->references('id')->on('levels')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('results');
    }
}

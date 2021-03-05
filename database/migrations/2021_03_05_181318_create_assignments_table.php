<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->date('deadline')->nullable();
            $table->text('description')->nullable();
            $table->longText('references')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}

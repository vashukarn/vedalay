<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('completion',['COMPLETE','INCOMPLETE'])->default('INCOMPLETE');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}

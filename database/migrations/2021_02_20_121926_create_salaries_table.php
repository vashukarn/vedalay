<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->enum('rollback',['1','0'])->default(0);
            $table->enum('month',['1','2','3','4','5','6','7','8','9','10','11','12'])->nullable();
            $table->string('monthly_salary')->nullable();
            $table->string('tada')->nullable();
            $table->string('extra_class')->nullable();
            $table->string('incentive')->nullable();
            $table->string('transport_charges')->nullable();
            $table->string('leave_charges')->nullable();
            $table->string('bonus')->nullable();
            $table->string('advance_salary')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('added_by')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salaries');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();
            $table->longText('fee_details')->default(0);
            $table->enum('payment_method',['Bank Transfer','Cash','UPI','Card','Paytm'])->default('Cash');
            $table->string('upi_type')->nullable();
            $table->string('bank_ifsc')->nullable();
            $table->string('bank_accountno')->nullable();
            $table->string('transfer_phone')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('transfer_date')->nullable();
            $table->string('card_type')->nullable();
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('session')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id')->references('id')->on('levels')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('session')->references('id')->on('sessions')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('student_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
        Schema::dropIfExists('fee_payments');
    }
}

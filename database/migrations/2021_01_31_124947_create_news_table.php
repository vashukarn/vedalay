<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();

            $table->text('title')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('description')->nullable();
            $table->text('category')->nullable();
            $table->text('tags')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('path')->nullable()->comment('image path after uploads');
            $table->text('slug')->unique()->nullable();
            $table->unsignedBigInteger('reporter')->nullable();
            $table->foreign('reporter')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->enum('publish_status', ['0', '1'])->default('1');
            $table->enum('postType', ['news', 'blog', 'talks', 'article'])->default('news');
            $table->bigInteger('view_count')->default(0);
            $table->text('meta_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyphrase')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
        DB::update("ALTER TABLE news AUTO_INCREMENT= 10000;");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}

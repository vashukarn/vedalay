<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(true);
            $table->date('date')->nullable(true);
            $table->string('slug')->nullable(true);
            $table->text('excerpt')->nullable(true);
            $table->text('description')->nullable(true);
            $table->string('external_url')->nullable(true);
            $table->string('featured_img')->nullable(true);
            $table->string('parallex_img')->nullable(true);
            $table->string('code')->nullable(true);

            $table->enum('publish_status', ['0','1'])->default(1);
            $table->enum('delete_status', ['0','1'])->default(0);
            $table->enum('featured_news',['0','1'])->default(0);
            $table->bigInteger('view_count')->default(0);

            $table->text('meta_title')->nullable(true);
            $table->text('meta_keyword')->nullable(true);
            $table->text('meta_description')->nullable(true);

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
        Schema::dropIfExists('blogs');
    }
}

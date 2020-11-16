<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsCrawlersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_crawler', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('category_id');
            $table->longText('short_content');
            $table->longText('content');
            $table->longText('url_img');
            $table->string('post_date');
            $table->string('news_relate')->nullable();
            $table->longText('title_website');
            $table->longText('description');
            $table->string('keyword');
            $table->longText('sort');
            $table->integer('active');
            $table->longText('post_author');
            $table->longText('post_source');
            $table->longText('post_author_update');
            $table->longText('post_author_delete');
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
        Schema::dropIfExists('news_crawler');
    }
}

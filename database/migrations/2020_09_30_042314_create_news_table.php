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
            $table->increments('id');
            $table->string('news_title', 255);
            $table->longText('news_description');
            $table->string('news_feature_image', 255);
            $table->longText('news_image');
            $table->string('news_type', 50);
            $table->string('news_status', 50);
            $table->tinyInteger('news_comment_status');
            $table->float('news_price_from');
            $table->float('news_price_to');
            $table->string('news_logo', 255);
            $table->float('news_price_meters_from');
            $table->float('news_price_meters_to');
            $table->float('news_investment');
            $table->float('news_building_density');
            $table->float('news_land_area');
            $table->bigInteger('news_author');
            $table->string('news_project', 255)->nullable();
            $table->string('news_street', 255)->nullable();
            $table->string('news_district', 255)->nullable();
            $table->string('news_ward', 255)->nullable();
            $table->string('news_province', 255)->nullable();
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
        Schema::dropIfExists('news');
    }
}

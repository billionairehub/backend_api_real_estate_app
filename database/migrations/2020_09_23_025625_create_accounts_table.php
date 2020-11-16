<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',150);
            $table->string('passwords');
            $table->string('phone',11)->nullable();
            $table->string('email',150)->nullable();
            $table->string('url_avata',255);
            $table->string('url_cover_image',255);
            $table->text('personal_infor')->nullable();
            $table->string('id_token_faceboook',255)->nullable();
            $table->string('id_token_google',255)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('code', 6)->nullable();
            $table->double('code_time_expireds', 20)->nullable();
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
        Schema::dropIfExists('account');
    }
}

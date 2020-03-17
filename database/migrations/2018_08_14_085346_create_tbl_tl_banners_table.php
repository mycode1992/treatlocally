<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTlBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tl_banners', function (Blueprint $table) {
            $table->increments('tl_banner_id');
            $table->string('tl_banner_title');
            $table->string('tl_banner_image');
            $table->string('tl_banner_ip');
            $table->string('tl_banner_update_at');
           // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_tl_banners');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTlHowitworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tl_howitworks', function (Blueprint $table) {
            $table->increments('tl_howitworks_id');
            $table->string('tl_howitworks_icon1');
            $table->string('tl_howitworks_icon2');
            $table->string('tl_howitworks_icon3');
            $table->string('tl_howitworks_text1');
            $table->string('tl_howitworks_text2');
            $table->string('tl_howitworks_text3');  
            $table->string('tl_howitworks_ip');
            $table->string('tl_howitworks_update_at');
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
        Schema::dropIfExists('tbl_tl_howitworks');
    }
}

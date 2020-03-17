<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTlContactusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tl_contactuses', function (Blueprint $table) {
            $table->increments('tl_contactus_id');  
            $table->string('tl_contactus_name');
            $table->string('tl_contactus_email');
            $table->string('tl_contactus_phone');
            $table->string('tl_contactus_company');     
            $table->string('tl_contactus_message');     
            $table->string('tl_contactus_ip');     
            $table->string('tl_contactus_created_at');   
            $table->string('tl_contactus_updated_at');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_tl_contactuses');
    }
}

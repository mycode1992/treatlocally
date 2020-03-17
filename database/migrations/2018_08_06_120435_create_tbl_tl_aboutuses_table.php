<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTlAboutusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tl_aboutuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tl_aboutus_imagename');
            $table->string('tl_aboutus_content');
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
        Schema::dropIfExists('tbl_tl_aboutuses');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTlPrivacypoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tl_privacypolicies', function (Blueprint $table) {
            $table->increments('tl_privacypolicies_id');
            $table->string('tl_privacypolicies_imagename');
            $table->string('tl_privacypolicies_content');
            $table->string('tl_privacypolicies_ip');
            $table->string('tl_privacypolicies_updated_at');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_tl_privacypolicies');
    }
}

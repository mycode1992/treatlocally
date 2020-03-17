<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_tl_banner extends Model
{
    protected $table='tbl_tl_banner';
     public $timestamps = false;
   protected $fillable = ['tl_banner_image','tl_banner_title','tl_banner_ip','tl_banner_update_at'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
  /**
    * 获得与用户关联的电话记录。
    */
   public function role()
   {
       return $this->belongsTo('App\Models\Role', 'roleid');
   }
}

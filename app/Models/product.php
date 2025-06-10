<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
       protected $fillable = ['user_id', 'name' , 'price','category_id','is_approved','description'];

       public function files(){
         return $this->hasMany(product_file::class);
       }
}

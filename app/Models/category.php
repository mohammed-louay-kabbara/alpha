<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
       protected $fillable = ['name', 'image'];

       public function product()
       {
              return $this->hasMany(product::class);
       }
}

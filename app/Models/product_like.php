<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product_like extends Model
{
    protected $fillable = [
      'user_id' , 'type' , 'product_id'
    ];
     protected $table = 'product_likes';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

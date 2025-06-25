<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class follower extends Model
{
    protected $fillable = ['followed_id', 'follower_id' ];
    
    public function user(){
    return $this->belongsTo(User::class);
  }

}

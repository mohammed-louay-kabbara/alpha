<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reel_likes extends Model
{
       protected $fillable = [
      'user_id' , 'type' , 'reels_id'
    ];
}

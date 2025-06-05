<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reel_comments extends Model
{
    protected $fillable = [
      'user_id' , 'message' , 'reels_id'
    ];
}

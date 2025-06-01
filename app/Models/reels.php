<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reels extends Model
{
    protected $fillable = [
      'user_id' , 'media_path' , 'description' , 'likes_count' , 'dislikes_count'
    ];
}

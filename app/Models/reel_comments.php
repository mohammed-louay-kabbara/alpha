<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reel_comments extends Model
{
    protected $fillable = [
      'user_id' , 'message' , 'reels_id'
    ];

    public function user()
   {
     return $this->belongsTo(User::class);
   }
    public function comments()
    {
      return $this->morphMany(Comment::class, 'commentable');
    }
}

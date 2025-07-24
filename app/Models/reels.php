<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reels extends Model
{
    protected $fillable = [
      'user_id' , 'media_path' , 'description' , 'likes_count' , 'dislikes_count'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
   
   public function favorites()
  {
    return $this->morphMany(Favorite::class, 'favoritable');
  }

  public function reportable()
  {
      return $this->morphTo(__FUNCTION__, 'report_typeable_type', 'report_typeable_id');
  }


}

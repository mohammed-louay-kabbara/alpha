<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product_comments extends Model
{
        protected $fillable = [
      'user_id' , 'message' , 'product_id'
    ];

    public function user()
   {
     return $this->belongsTo(User::class);
   }
    public function likes()
    {
        return $this->morphMany(comment_reactions::class, 'commentable');
    }

}

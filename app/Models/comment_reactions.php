<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comment_reactions extends Model
{
    protected $fillable = ['commentable', 'reaction' , 'user_id'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
       protected $fillable = [ 'user_id' , 'started_at' ,'ended_at', 'duration'];
}

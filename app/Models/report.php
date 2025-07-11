<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class report extends Model
{
    protected $fillable = [
      'user_id' , 'report_typeable_type' , 'report_typeable_id' 
    ];

    public function report_typeable()
    {
        return $this->morphTo();
    }
    
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
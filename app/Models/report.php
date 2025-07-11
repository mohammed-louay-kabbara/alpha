<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class report extends Model
{
    protected $fillable = [
      'user_id' , 'report_typeable_type' , 'report_typeable_id' 
    ];

    public function reportable()
    {
      return $this->morphTo('report_typeable');
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class advertisement extends Model
{
    protected $fillable = ['image', 'description','publishing_end','type'];
}

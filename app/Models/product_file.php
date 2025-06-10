<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product_file extends Model
{
    protected $fillable = ['product_id', 'file_path', 'file_type'];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

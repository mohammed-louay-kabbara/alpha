<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
  protected $fillable = ['user_id', 'name' , 'price','category_id','is_approved','description','is_sold'];
  public function files(){
    return $this->hasMany(product_file::class);
  }

  public function likes(){
    return $this->hasMany(product_like::class);
  }

  public function user(){
    return $this->belongsTo(User::class);
  }
  public function category(){
    return $this->belongsTo(category::class);
  }

  public function reports()
  {
    return $this->morphMany(Report::class, 'report_typeable');
  }
  public function likeTypes()
  {
      return $this->hasMany(product_like::class)
                  ->select('type')
                  ->distinct('type');
  }
  
}

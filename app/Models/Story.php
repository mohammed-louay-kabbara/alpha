<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
 protected $fillable = ['user_id', 'media', 'type', 'caption', 'expires_at'];
 
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function views()
    {
        return $this->hasMany(story_view::class);
    }
    public function scopeExpired($query)
    {
        return $query->where('created_at', '<', now()->subDay());
    }

}

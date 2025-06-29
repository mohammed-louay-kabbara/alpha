<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPrivacySetting extends Model
{
    protected $fillable = [
        'followers_visibility' , 'user_id' , 
        'profile_visibility' , 'comment_permission' ,
        'reaction_visibility'
    ];
    public function privacySettings()
    {
        return $this->hasOne(UserPrivacySetting::class);
    }
}

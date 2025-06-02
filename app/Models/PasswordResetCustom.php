<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetCustom extends Model
{
      protected $fillable = [
        'email', 'otp_code', 'expires_at'
    ];
    
}

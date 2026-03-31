<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MobileUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'otp',
        'otp_token',
        'password_otp',
        'password_token',
    ];

    public function getUserImageAttribute($value)
    {
        return get_uploaded_image_url($value, 'user_image_upload_dir');
    }
}

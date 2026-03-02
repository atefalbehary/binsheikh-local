<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo404Log extends Model
{
    use HasFactory;

    protected $table = 'seo_404_logs';
    protected $fillable = ['url', 'hits', 'last_hit_at'];
    protected $dates = ['last_hit_at'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesToolkit extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'file_path', 'assigned_to'];

    protected $casts = [
        'assigned_to' => 'array',
    ];
}

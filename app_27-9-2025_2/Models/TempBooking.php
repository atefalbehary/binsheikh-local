<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempBooking extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $table = "temp_bookings";
    public $timestamps = false;
}

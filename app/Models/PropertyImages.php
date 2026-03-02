<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class PropertyImages extends Model
{
    use HasFactory;

    protected $fillable = ['property_id', 'image', 'order', 'alt_text', 'alt_text_ar'];

    use HasFactory;

    protected $guarded = [];

}


<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class FavouriteProperty extends Model

{

    use HasFactory;

    protected $guarded = [];

    protected $table = "favourite_properties";

    public function property_details(){
        return $this->hasOne(Properties::class,'id','property_id');
    }
}


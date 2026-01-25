<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Properties extends Model
{

    use HasFactory;
    const BUY = 1;
    const RENT = 2;
    const BUY_RENT = 3;

    const saleType = array('BUY'=>'1', 'RENT'=>'2','BUY_RENT'=>3 );
    protected $guarded = [];

    protected $casts = [
        'is_sold' => 'boolean',
        'is_recommended' => 'boolean'
    ];

    public function __get($key)
    {
        if (\Request::is('admin/*')) {
            return parent::__get($key);
        }
        $locale = app()->getLocale();
        if ($locale != "en") {
            $localizedKey = $key . '_' . $locale;
        }else{
            $localizedKey = $key;
        }
        if (array_key_exists($localizedKey, $this->attributes)) {
            return $this->attributes[$localizedKey];
        }
        return parent::__get($key);
    }


    public static function getSlug($value, $exclude = '')
    {
        if (static::whereSlug($slug = Str::slug($value, '-'))->exists()) {
            $slug = self::incrementSlug($slug, $exclude);
        }
        return $slug;
    }

    public static function incrementSlug($slug, $exclude = '')
    {

        $original = $slug;

        $count = 1;

        if ($exclude) {

            while (static::whereSlug($slug)->where('id', '!=', $exclude)->exists()) {

                $slug = "{$original}-" . $count++;

            }

        } else {

            while (static::whereSlug($slug)->exists()) {

                $slug = "{$original}-" . $count++;

            }
        }
        return $slug;
    }

    public function amenities()
    {
        return $this->hasMany(PropertyAmenities::class, 'property_id', 'id')->orderBy('id', 'asc');
    }

    public function images()
    {
        return $this->hasMany(PropertyImages::class, 'property_id', 'id');
    }
    public function property_type()
    {
        return $this->hasOne(Categories::class, 'id', 'category');
    }
    public function project()
    {
        return $this->hasOne(Projects::class, 'id', 'project_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Projects extends Model
{

    use HasFactory;

    protected $guarded = [];
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

    public function images()
    {
        return $this->hasMany(ProjectImages::class, 'project_id', 'id');
    }

}

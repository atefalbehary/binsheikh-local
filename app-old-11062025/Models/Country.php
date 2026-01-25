<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $table="country";
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
}

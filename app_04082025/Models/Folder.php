<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;
    protected $table = 'folders';
    protected $guarded = [];
    protected $fillable = [
        'title',
        'title_ar',
        'cover_image',
        'is_pinned'
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
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Video extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['link', 'active', 'folder_id', 'alt_text', 'alt_text_ar'];

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

}


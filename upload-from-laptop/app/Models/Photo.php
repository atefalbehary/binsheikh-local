<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Photo extends Model

{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'folder_id',
        'image',
        'active'
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

}


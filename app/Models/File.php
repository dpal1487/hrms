<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['file_name', 'file_path', 'file_size', 'file_mime', 'file_extension', 'status'];

    public function image()
    {
        return $this->belongsTo(ItemImage::class, 'image_id', 'id');
    }

    public function images()
    {
        return $this->belongsTo(ItemImage::class, 'image_id', 'id');
    }
}

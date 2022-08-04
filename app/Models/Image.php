<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['image_url'];

    public function imageable()
    {
        # code...
        return $this->morphTo();
    }
    // Accessor
    public function getImageUrlAttribute()
    {
        if ($this->attributes['name']) {
            return asset('images/' . $this->attributes['name']);
        }
    }
}

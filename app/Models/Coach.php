<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $fillable = ['name', 'rank', 'image']; // Tambahkan image di sini

    // Menyimpan gambar
    public function setImageAttribute($value)
    {
        if ($value) {
            $imageName = time() . '.' . $value->extension();
            $value->move(public_path('images/coaches'), $imageName);
            $this->attributes['image'] = $imageName;
        }
    }
}

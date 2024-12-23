<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoKarate extends Model
{
    use HasFactory;

    protected $table = 'info_karate';

    protected $fillable = [
        'title',
        'date',
        'place',
        'image',
    ];
}

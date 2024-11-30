<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePelatih extends Model
{
    use HasFactory;
    protected $table = "profile_pelatih";

    protected $fillable = [
        'nama_awal',
        'nama_akhir',
        'pangkat',
        'foto',
    ];
}

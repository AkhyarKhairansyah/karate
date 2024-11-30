<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coach;

class CoachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        Coach::create(['name' => 'Ari Muhammad Zaki', 'rank' => 'Dan III']);
        Coach::create(['name' => 'Ferry Eka Putra', 'rank' => 'Dan III']);
        Coach::create(['name' => 'Rifqi Nurgiansyah', 'rank' => 'Dan III']);
        Coach::create(['name' => 'Muhammad Rafie Mugia', 'rank' => 'Dan I']);
    }

}

<?php

namespace Database\Seeders;

use App\Models\Tirada;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class TiradaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tirada::factory(10)->create();
    }
}

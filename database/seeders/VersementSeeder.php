<?php

namespace Database\Seeders;

use App\Models\Versement;
use Illuminate\Database\Seeder;

class VersementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Versement::factory()->count(5)->create();
    }
}

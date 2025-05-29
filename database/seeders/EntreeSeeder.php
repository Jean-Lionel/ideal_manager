<?php

namespace Database\Seeders;

use App\Models\Entree;
use Illuminate\Database\Seeder;

class EntreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Entree::factory()->count(5)->create();
    }
}

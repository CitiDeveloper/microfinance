<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Borrower;

class BorrowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate 20 fake borrowers
        Borrower::factory()->count(20)->create();
    }
}

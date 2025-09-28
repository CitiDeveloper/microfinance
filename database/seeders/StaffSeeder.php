<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        // Create 1 staff for each of the 6 roles
        foreach (range(1, 6) as $roleId) {
            Staff::factory()->create([
                'staff_role_id' => $roleId,
            ]);
        }

        // Create additional random staff (optional)
        Staff::factory()->count(20)->create();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoanStatus;

class LoanStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['id' => 2, 'name' => 'Processing'],
            ['id' => 1, 'name' => 'Open', 'is_default' => true],
            ['id' => 3, 'name' => 'Defaulted'],
            ['id' => 4, 'name' => 'Credit Counseling'],
            ['id' => 5, 'name' => 'Collection Agency'],
            ['id' => 6, 'name' => 'Sequestrate'],
            ['id' => 7, 'name' => 'Debt Review'],
            ['id' => 8, 'name' => 'Fraud'],
            ['id' => 9, 'name' => 'Investigation'],
            ['id' => 10, 'name' => 'Legal'],
            ['id' => 11, 'name' => 'Write-Off'],
            ['id' => 12, 'name' => 'Denied'],
            ['id' => 13, 'name' => 'Not Taken Up'],
        ];

        foreach ($statuses as $status) {
            LoanStatus::updateOrCreate(
                ['id' => $status['id']],
                [
                    'name' => $status['name'],
                    'is_default' => $status['is_default'] ?? false,
                ]
            );
        }
    }
}

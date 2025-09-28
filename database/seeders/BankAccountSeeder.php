<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            [
                'coa_code' => '1001',
                'coa_name' => 'Main Cash Account',
                'coa_default_categories' => json_encode(['cash', 'operational']),
                'access_branches' => json_encode([1, 2]), // example branch IDs
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coa_code' => '1002',
                'coa_name' => 'Bank of Kenya - Operations',
                'coa_default_categories' => json_encode(['bank', 'operations']),
                'access_branches' => json_encode([1]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coa_code' => '1003',
                'coa_name' => 'Savings Account',
                'coa_default_categories' => json_encode(['savings']),
                'access_branches' => json_encode([2, 3]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('bank_accounts')->insert($accounts);
    }
}

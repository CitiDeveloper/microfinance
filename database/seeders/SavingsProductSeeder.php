<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SavingsProduct;

class SavingsProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Jipange Savings Account',
                'code' => 'JIP001',
                'description' => 'Flexible savings account for individuals to save daily or weekly with no penalty.',
                'interest_rate' => 3.50,
                'interest_calculation' => 'monthly',
                'minimum_deposit' => 100.00,
                'maximum_deposit' => 50000.00,
                'minimum_balance' => 500.00,
                'allow_withdrawals' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Chama Savings Account',
                'code' => 'CHA001',
                'description' => 'Group savings account designed for chamas and self-help groups.',
                'interest_rate' => 4.00,
                'interest_calculation' => 'quarterly',
                'minimum_deposit' => 500.00,
                'maximum_deposit' => 200000.00,
                'minimum_balance' => 2000.00,
                'allow_withdrawals' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Junior Saver',
                'code' => 'JUN001',
                'description' => 'Savings account for children below 18 years, encouraging early saving culture.',
                'interest_rate' => 5.00,
                'interest_calculation' => 'annually',
                'minimum_deposit' => 200.00,
                'maximum_deposit' => 100000.00,
                'minimum_balance' => 1000.00,
                'allow_withdrawals' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Fixed Deposit Account',
                'code' => 'FIX001',
                'description' => 'High-interest fixed deposit account for individuals and SMEs.',
                'interest_rate' => 7.50,
                'interest_calculation' => 'maturity',
                'minimum_deposit' => 10000.00,
                'maximum_deposit' => 1000000.00,
                'minimum_balance' => 10000.00,
                'allow_withdrawals' => false,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            SavingsProduct::create($product);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'name' => 'M-Pesa',
                'code' => 'MPESA',
                'description' => 'Mobile money payment via Safaricom M-Pesa.',
            ],
            [
                'name' => 'Bank Transfer',
                'code' => 'BANK',
                'description' => 'Payment via direct bank transfer.',
            ],
            [
                'name' => 'Cash',
                'code' => 'CASH',
                'description' => 'Physical cash payment at branch.',
            ],
            [
                'name' => 'Cheque',
                'code' => 'CHEQUE',
                'description' => 'Payment via bank cheque.',
            ],
            [
                'name' => 'Airtel Money',
                'code' => 'AIRTEL',
                'description' => 'Mobile money payment via Airtel Money.',
            ],
            [
                'name' => 'Equity Bank App',
                'code' => 'EQ_APP',
                'description' => 'Payment via Equity Bank mobile app.',
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(['code' => $method['code']], $method);
        }
    }
}

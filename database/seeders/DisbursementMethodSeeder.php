<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DisbursementMethod;

class DisbursementMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            'Cash',
            'Cheque',
            'Wire Transfer',
            'Online Transfer',
        ];

        foreach ($methods as $method) {
            DisbursementMethod::firstOrCreate(['name' => $method]);
        }
    }
}

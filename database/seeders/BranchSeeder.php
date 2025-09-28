<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'branch_name' => 'Nairobi Main Branch',
                'branch_open_date' => Carbon::create(2010, 1, 15),
                'account_settings_override' => false,
                'branch_country' => 'KEN',
                'branch_currency' => 'KES',
                'branch_dateformat' => 'd/m/Y',
                'branch_currency_in_words' => 'Kenyan Shillings',
                'branch_address' => 'Moi Avenue, Nairobi',
                'branch_city' => 'Nairobi',
                'branch_province' => 'Nairobi County',
                'branch_zipcode' => '00100',
                'branch_landline' => '020-1234567',
                'branch_mobile' => '+254700123456',
                'branch_min_loan_amount' => 500,
                'branch_max_loan_amount' => 500000,
                'branch_min_interest_rate' => 1.0,
                'branch_max_interest_rate' => 5.0,
                'borrower_num_placeholder' => 'BR-{YYYY}-{0000}',
                'loan_num_placeholder' => 'LN-{YYYY}-{0000}',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'branch_name' => 'Mombasa Coastal Branch',
                'branch_open_date' => Carbon::create(2012, 5, 10),
                'account_settings_override' => false,
                'branch_country' => 'KEN',
                'branch_currency' => 'KES',
                'branch_dateformat' => 'd/m/Y',
                'branch_currency_in_words' => 'Kenyan Shillings',
                'branch_address' => 'Moi Avenue, Mombasa',
                'branch_city' => 'Mombasa',
                'branch_province' => 'Mombasa County',
                'branch_zipcode' => '80100',
                'branch_landline' => '041-1234567',
                'branch_mobile' => '+254700654321',
                'branch_min_loan_amount' => 500,
                'branch_max_loan_amount' => 300000,
                'branch_min_interest_rate' => 1.5,
                'branch_max_interest_rate' => 6.0,
                'borrower_num_placeholder' => 'BR-{YYYY}-{0000}',
                'loan_num_placeholder' => 'LN-{YYYY}-{0000}',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'branch_name' => 'Kisumu Lakeside Branch',
                'branch_open_date' => Carbon::create(2015, 3, 20),
                'account_settings_override' => false,
                'branch_country' => 'KEN',
                'branch_currency' => 'KES',
                'branch_dateformat' => 'd/m/Y',
                'branch_currency_in_words' => 'Kenyan Shillings',
                'branch_address' => 'Jomo Kenyatta Road, Kisumu',
                'branch_city' => 'Kisumu',
                'branch_province' => 'Kisumu County',
                'branch_zipcode' => '40100',
                'branch_landline' => '057-1234567',
                'branch_mobile' => '+254701234567',
                'branch_min_loan_amount' => 1000,
                'branch_max_loan_amount' => 200000,
                'branch_min_interest_rate' => 1.0,
                'branch_max_interest_rate' => 5.5,
                'borrower_num_placeholder' => 'BR-{YYYY}-{0000}',
                'loan_num_placeholder' => 'LN-{YYYY}-{0000}',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'branch_name' => 'Nakuru Rift Valley Branch',
                'branch_open_date' => Carbon::create(2018, 7, 15),
                'account_settings_override' => false,
                'branch_country' => 'KEN',
                'branch_currency' => 'KES',
                'branch_dateformat' => 'd/m/Y',
                'branch_currency_in_words' => 'Kenyan Shillings',
                'branch_address' => 'Kenya Road, Nakuru',
                'branch_city' => 'Nakuru',
                'branch_province' => 'Nakuru County',
                'branch_zipcode' => '20100',
                'branch_landline' => '051-1234567',
                'branch_mobile' => '+254702345678',
                'branch_min_loan_amount' => 1000,
                'branch_max_loan_amount' => 250000,
                'branch_min_interest_rate' => 1.2,
                'branch_max_interest_rate' => 5.5,
                'borrower_num_placeholder' => 'BR-{YYYY}-{0000}',
                'loan_num_placeholder' => 'LN-{YYYY}-{0000}',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('branches')->insert($branches);
    }
}

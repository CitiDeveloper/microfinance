<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AfterMaturityInterestOption;

class AfterMaturityInterestOptionSeeder extends Seeder
{
    public function run(): void
    {
        $options = [
            ['value' => 0, 'label' => ''],
            ['value' => 1, 'label' => 'Overdue Principal Amount'],
            ['value' => 7, 'label' => 'Overdue Interest Amount'],
            ['value' => 2, 'label' => 'Overdue (Principal + Interest) Amount'],
            ['value' => 3, 'label' => 'Overdue (Principal + Interest + Fees) Amount'],
            ['value' => 6, 'label' => 'Overdue (Principal + Interest + Penalty) Amount'],
            ['value' => 4, 'label' => 'Overdue (Principal + Interest + Fees + Penalty) Amount'],
            ['value' => 8, 'label' => 'Overdue (Interest + Fees) Amount'],
            ['value' => 5, 'label' => 'Total Principal Amount Released'],
            ['value' => 9, 'label' => 'Total Principal Balance Amount'],
            ['value' => 10, 'label' => 'Maturity Date Installment Only - Overdue Principal Amount'],
            ['value' => 11, 'label' => 'Maturity Date Installment Only - Overdue Interest Amount'],
            ['value' => 12, 'label' => 'Maturity Date Installment Only - Overdue (Principal + Interest) Amount'],
            ['value' => 13, 'label' => 'Maturity Date Installment Only - Overdue (Principal + Interest + Fees) Amount'],
            ['value' => 14, 'label' => 'Maturity Date Installment Only - Overdue (Principal + Interest + Fees + Penalty) Amount'],
            ['value' => 15, 'label' => 'Maturity Date Installment Only - Overdue (Interest + Fees) Amount'],
        ];

        foreach ($options as $option) {
            AfterMaturityInterestOption::create($option);
        }
    }
}

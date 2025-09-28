<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    protected $model = Staff::class;

    public function definition(): array
    {
        return [
            'staff_role_id' => $this->faker->numberBetween(1, 6), // one of the 6 roles
            'staff_payroll_branch_id' => null, // adjust if you have branches
            'staff_firstname' => $this->faker->firstName(),
            'staff_lastname' => $this->faker->lastName(),
            'staff_email' => $this->faker->unique()->safeEmail(),
            'staff_gender' => $this->faker->randomElement(['Male', 'Female']),
            'staff_show_results' => 20,
            'staff_mobile' => $this->faker->numerify('07########'),
            'staff_dob' => $this->faker->date(),
            'staff_address' => $this->faker->address(),
            'staff_city' => $this->faker->city(),
            'staff_province' => $this->faker->state(),
            'staff_zipcode' => $this->faker->postcode(),
            'staff_office_phone' => $this->faker->numerify('02#######'),
            'staff_teams' => $this->faker->word(),
            'staff_photo' => null,
        ];
    }
}

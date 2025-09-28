<?php
namespace Database\Factories;

use App\Models\Borrower;
use Illuminate\Database\Eloquent\Factories\Factory;

class BorrowerFactory extends Factory
{
protected $model = Borrower::class;

public function definition()
{
$hasBusiness = $this->faker->boolean(30);

return [
'county' => $this->faker->randomElement(['Nairobi','Mombasa','Kisumu','Nakuru','Kiambu']),
'first_name' => $hasBusiness ? null : $this->faker->firstName(),
'last_name' => $hasBusiness ? null : $this->faker->lastName(),
'business_name' => $hasBusiness ? $this->faker->company() : null,
'unique_number' => 'BN' . $this->faker->unique()->numberBetween(100000, 999999),
'gender' => $this->faker->randomElement(['Male', 'Female', 'Nonbinary', 'Other']),
'title' => $this->faker->randomElement(['Mr.', 'Mrs.', 'Miss', 'Ms.', 'Dr.']),
'mobile' => $this->faker->numerify('7########'),
'email' => $this->faker->unique()->safeEmail(),
'date_of_birth' => $this->faker->date(),
'address' => $this->faker->address(),
'city' => $this->faker->city(),
'province' => $this->faker->state(),
'zipcode' => $this->faker->postcode(),
'landline' => $this->faker->numerify('########'),
'working_status' => $this->faker->randomElement([
'Employee','Government Employee','Private Sector Employee','Owner','Student','Business Person','Unemployed','Pensioner'
]),
'credit_score' => $this->faker->numberBetween(300, 850),
'description' => $this->faker->paragraph(),
];
}
}
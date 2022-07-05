<?php

namespace Database\Factories;

use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = $this->faker->numberBetween(1,42);
        $gender = ["Male","Female"];
        $ms = ['Divorced', 'Married', 'Single', 'Widowed', 'Separated'];
        $sts = ['active', 'fired', 'retired', 'resigned', 'deceased'];
        return [
            //
            'user_id' => $user_id,
            'surname' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'other_names' => $this->faker->lastName,
            'gender' => $gender[$this->faker->numberBetween(0,1)],
            'marital_status' => $ms[$this->faker->numberBetween(0,4)],
            'current_level' => $this->faker->numberBetween(0,14),
            'permanent_address' => $this->faker->address,
            'contact_address' => $this->faker->address,
            'personnel_number' => "ABP".$user_id,
            'department_id' => $this->faker->numberBetween(0,4),
            'status' => $sts[$this->faker->numberBetween(0,4)],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

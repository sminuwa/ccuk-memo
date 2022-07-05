<?php

namespace Database\Factories;

use App\Models\Minute;
use Illuminate\Database\Eloquent\Factories\Factory;

class MinuteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Minute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'flag' => 'positive',
            'memo_id' => $this->faker->numberBetween(1,20),
            'from_user' => $this->faker->numberBetween(1,10),
            'to_user' => $this->faker->numberBetween(1,10),
            'confidentiality' => "not confidential",
            'body' => $this->faker->text,
            'copy' => "",
            'status' => "not seen",
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

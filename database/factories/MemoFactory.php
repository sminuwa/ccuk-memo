<?php

namespace Database\Factories;

use App\Models\Memo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MemoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Memo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'body' => $this->faker->text,
            'raise_by' => $this->faker->numberBetween(1,10),
            'raised_for' => $this->faker->numberBetween(1,10),
            'date_raised' => $this->faker->date(),
            'copy' => "",
            'status' => "open",
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

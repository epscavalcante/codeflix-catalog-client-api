<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => "{$this->faker->colorName()} {$this->faker->company()}",
            'description' => $this->faker->boolean() ? $this->faker->sentences(rand(1, 5), true) : null,
            'is_active' => $this->faker->boolean(),
            'created_at' => $this->faker->iso8601()
        ];
    }
}

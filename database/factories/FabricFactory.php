<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FabricFactory extends Factory
{
    public function definition(): array
    {
        static $counter = 0;
        $counter++;
        return [
            'fabric_code' => 'FAB-' . str_pad($counter, 3, '0', STR_PAD_LEFT) . '-' . $this->faker->unique()->numerify('###'),
            'fabric_name' => $this->faker->words(3, true),
            'fabric_type' => $this->faker->randomElement(['Knitted', 'Woven', 'Non-Woven']),
            'composition' => '100% Cotton',
            'color'       => $this->faker->colorName(),
            'gsm'         => $this->faker->randomFloat(2, 100, 300),
            'width'       => $this->faker->randomFloat(2, 50, 100),
            'unit'        => $this->faker->randomElement(['KG', 'Meter', 'Yard']),
            'description' => $this->faker->sentence(),
            'status'      => 'active',
        ];
    }

    public function inactive(): static
    {
        return $this->state(['status' => 'inactive']);
    }
}

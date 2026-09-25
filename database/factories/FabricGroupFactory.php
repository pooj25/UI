<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FabricGroupFactory extends Factory
{
    public function definition(): array
    {
        static $counter = 0;
        $counter++;
        return [
            'group_code'  => 'FG-' . str_pad($counter, 3, '0', STR_PAD_LEFT) . '-' . $this->faker->unique()->numerify('###'),
            'group_name'  => $this->faker->words(3, true) . ' Group',
            'description' => $this->faker->sentence(),
            'status'      => 'active',
        ];
    }

    public function inactive(): static
    {
        return $this->state(['status' => 'inactive']);
    }
}

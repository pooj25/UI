<?php

namespace Database\Factories;

use App\Models\Fabric;
use App\Models\FabricGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class LayModelFactory extends Factory
{
    public function definition(): array
    {
        static $counter = 0;
        $counter++;
        return [
            'lay_model_code'  => 'LM-' . str_pad($counter, 3, '0', STR_PAD_LEFT) . '-' . $this->faker->unique()->numerify('###'),
            'lay_model_name'  => $this->faker->words(3, true) . ' Lay',
            'fabric_group_id' => FabricGroup::factory(),
            'fabric_id'       => Fabric::factory(),
            'lay_length'      => $this->faker->randomFloat(2, 5, 20),
            'lay_width'       => $this->faker->randomFloat(2, 50, 100),
            'number_of_plies' => $this->faker->numberBetween(10, 100),
            'garment_size'    => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
            'marker_length'   => $this->faker->randomFloat(2, 4, 18),
            'marker_width'    => $this->faker->randomFloat(2, 45, 95),
            'description'     => $this->faker->sentence(),
            'status'          => 'active',
        ];
    }

    public function inactive(): static
    {
        return $this->state(['status' => 'inactive']);
    }
}

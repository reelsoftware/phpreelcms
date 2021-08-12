<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class VideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Video::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Str::random(36) . '.mp4',
            'storage' => 'local',
            'premium' => $this->faker->numberBetween(0, 1),
            'auth' => $this->faker->numberBetween(0, 1),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'url' => $this->faker->url,
            'media' => 'tulisan',
            'user_id' => User::factory(),
        ];
    }
}

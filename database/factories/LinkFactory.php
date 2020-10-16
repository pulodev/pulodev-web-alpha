<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Link::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'url' => $this->faker->url,
            'body' => $this->faker->sentence,
            'tags' => $this->faker->word,
            'media' => $this->faker->word,
            'user_id' => User::factory(),
            'original_published_at' => time(),
            'draft' => 1
        ];
    }
}

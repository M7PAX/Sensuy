<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\PostVotes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(5);

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'community_id' => Community::inRandomOrder()->first()->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->realText(),
            'votes' => 0,
        ];
    }
}

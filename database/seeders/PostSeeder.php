<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostVotes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()->count(5)->create()->each(function ($post) {
            // Create a random number of votes for each post
            $votes = PostVotes::factory()->count(rand(5, 15))->create(['post_id' => $post->id]);

            // Update the post's votes count
            $post->votes = $votes->sum('vote');
            $post->save();
        });
    }
}

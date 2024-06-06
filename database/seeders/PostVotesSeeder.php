<?php

namespace Database\Seeders;

use App\Models\PostVotes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostVotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $votes = PostVotes::factory()->count(5)->create();
    }
}

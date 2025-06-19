<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            // Create 5 top-level comments per post
            for ($i = 0; $i < 5; $i++) {
                $comment = Comment::create([
                    'user_id' => $users->random()->id,
                    'post_id' => $post->id,
                    'parent_id' => null,
                    'content' => $faker->sentence(10),
                    'created_at' => now()->subDays(rand(0, 5)),
                    'updated_at' => now()->subDays(rand(0, 5)),
                ]);

                // Create 2 replies per comment
                for ($j = 0; $j < 2; $j++) {
                    Comment::create([
                        'user_id' => $users->random()->id,
                        'post_id' => $post->id,
                        'parent_id' => $comment->id,
                        'content' => $faker->sentence(8),
                        'created_at' => now()->subDays(rand(0, 3)),
                        'updated_at' => now()->subDays(rand(0, 3)),
                    ]);
                }
            }
        }
    }
}

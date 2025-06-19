<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create user
        $user = User::firstOrCreate(
            ['email' => 'demo@example.com'],
            ['name' => 'Demo User', 'password' => bcrypt('password')]
        );

        // Create categories first
        $this->call(CategorySeeder::class);

        // Then create posts (now categories exist!)
        Post::factory(10)->create([
            'user_id' => $user->id,
        ]);

        //seeder for comments
        $this->call([
            CommentSeeder::class,
        ]);
    }

}

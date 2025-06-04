<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // safely fetch existing user or create only if not found
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'demo@example.com'],
            ['name' => 'Demo User', 'password' => bcrypt('password')]
        );

        //  create posts for that user
        \App\Models\Post::factory(10)->create([
            'user_id' => $user->id,
        ]);

        // seed categories
        $this->call(CategorySeeder::class);
    }

}

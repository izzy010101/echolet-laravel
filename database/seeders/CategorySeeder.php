<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $categories = ['Tech', 'Design', 'Wellness', 'Startups', 'Leadership'];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'user_id' => $user->id,
            ]);
        }
    }
}

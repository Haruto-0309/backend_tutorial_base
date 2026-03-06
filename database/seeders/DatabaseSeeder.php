<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $articles = \App\Models\Article::factory(3)->create();

        foreach ($articles as $article) {
            \App\Models\Comment::factory(3)->create([
                'article_id' => $article->id,
            ]);
        }

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            // 'email' => 'test@example.com',
        ]);
    }
}

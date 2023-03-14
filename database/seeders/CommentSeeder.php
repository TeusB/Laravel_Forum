<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;


class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        $posts->each(function ($post) use ($users) {
            for ($i = 0; $i < rand(0, 9); $i++) {
                Comment::factory()->create([
                    'idPost' => $post->id,
                    'idUser' => $users->random()->id,
                ]);
            }
        });
    }
}

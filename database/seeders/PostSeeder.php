<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;


class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $users->each(function ($user) {
            for ($i = 0; $i < rand(0, 5); $i++) {
                Post::factory()->create([
                    'idUser' => $user->id,
                ]);
            }
        });
    }
}

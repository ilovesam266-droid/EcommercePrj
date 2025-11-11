<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = Comment::factory()->count(20)->create();

        // Tạo 1-3 reply cho mỗi comment
        foreach ($comments as $comment) {
            $repliesCount = rand(1, 3);
            Comment::factory()->count($repliesCount)->reply($comment->id)->create();
        }
    }
}

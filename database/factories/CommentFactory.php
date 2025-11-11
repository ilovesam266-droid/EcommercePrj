<?php

namespace Database\Factories;

use App\Enums\CommentStatus;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        // Lấy random user và blog
        $userId = User::inRandomOrder()->first()?->id ?? 1;
        $blogId = Blog::inRandomOrder()->first()?->id ?? 1;

        // Chọn status random từ enum
        $status = CommentStatus::cases()[array_rand(CommentStatus::cases())];

        return [
            'user_id' => $userId,
            'blog_id' => $blogId,
            'content' => $this->faker->paragraph,
            'status' => $status,
            'parent_id' => null, // sẽ tạo reply riêng
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Tạo reply cho comment
    public function reply(int $parentId): self
    {
        return $this->state(fn(array $attributes) => [
            'parent_id' => $parentId,
        ]);
    }
}

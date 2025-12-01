<?php

namespace App\Repository\Eloquent;

use App\Repository\Constracts\BlogRepositoryInterface;
use App\Models\Blog;
use App\Models\Category;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{
    public function getModel()
    {
        return Blog::class;
    }

    public function getAllBlogs($perPage, $sort, $search, $filter)
    {
        return $this->all(
            $this->getFilteredBlog($filter, $search),
            ['created_at' => $sort],
            $perPage,
            ['*'],
            [
                'user',
                'categories',
            ],
            false,
        );
    }

    public function getFilteredBlog(array $filter = [], ?string $search = null)
    {
        return function ($query) use ($search) {
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhere('content', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($authorQuery) use ($search) {
                            $authorQuery->where('username', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('categories', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', '%' . $search . '%');
                        });
                });
            }
        };
    }

    public function trashedCount(): int
    {
        return $this->model->onlyTrashed()->count();
    }

    public function topCategories($limit = 5)
    {
        return Category::withCount(['blogs as total' => function ($query) {
            $query->whereNull('blogs.deleted_at');
        }])
            ->whereNull('categories.deleted_at')
            ->orderByDesc('total')
            ->limit($limit)
            ->get()
            ->map(fn($c) => [
                'name' => $c->name,
                'total' => $c->total,
            ]);
    }

    public function totalComments(): int
    {
        return $this->model->withCount('comments')->sum('content');
    }
}

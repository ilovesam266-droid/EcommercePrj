<?php

namespace App\Repository\Eloquent;

use App\Repository\Constracts\BlogRepositoryInterface;
use App\Models\Blog;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{
    public function getModel()
    {
        return Blog::class;
    }

    public function getFilteredBlog(array $filter = [], ?string $search = null)
    {
        return function ($query) use ($search) {
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhere('content', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($authorQuery) use ($search) {
                            $authorQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('categories', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', '%' . $search . '%');
                        });
                });
            }
        };
    }
}

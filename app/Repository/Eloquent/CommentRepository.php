<?php

namespace App\Repository\Eloquent;

use App\Models\Comment;
use App\Repository\Constracts\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function getModel()
    {
        return Comment::class;
    }

    public function getAllComments($perPage, $sort, $search, $filter){
        return $this->all(
            $this->getFilteredComment($filter, $search),
            ['created_at' => $sort],
            $perPage,
            ['*'],
            ['user', 'blog'],
            false,
        );
    }


    public function getFilteredComment(array $filter = [], ?string $search = null)
    {
        return function ($query) use ($filter, $search) {
            // Filter status enum
            if (!empty($filter['status'])) {
                $query->where('status', $filter['status']);
            }

            // Filter parent_id
            if (isset($filter['type'])) {
                if ($filter['type'] === 'comment') {
                    $query->whereNull('parent_id');
                } elseif ($filter['type'] === 'reply') {
                    $query->whereNotNull('parent_id');
                }
            }

            // Search
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    // User fields
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%");
                    });

                    // Blog fields
                    $q->orWhereHas('blog', function ($blogQuery) use ($search) {
                        $blogQuery->where('title', 'like', "%{$search}%")
                            ->orWhere('content', 'like', "%{$search}%");
                    });

                    // Content
                    $q->orWhere('content', 'like', "%{$search}%");
                });
            }
        };
    }

    public function getApprovedCount()
    {
        return $this->model->where('status', 'approved')->count();
    }

    public function getPendingCount()
    {
        return $this->model->where('status', 'pending')->count();
    }

    public function getByBlog(int $blogId)
    {
        return $this->model->where('blog_id', $blogId)->get();
    }

    public function getReplies(int $parentId)
    {
        return $this->model->where('parent_id', $parentId)->get();
    }
}

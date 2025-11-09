<?php

namespace App\Repository\Eloquent;

use App\Repository\Constracts\BlogRepositoryInterface;
use App\Models\Blog;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{
    public function getModel() {
        return Blog::class;
    }
}

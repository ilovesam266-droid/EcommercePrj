<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
use App\Repository\Constracts\CategoryRepositoryInterface;

class CategoryRepository  extends BaseRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }
}

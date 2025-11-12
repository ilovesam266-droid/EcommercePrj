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
    public function getFilteredCategory(array $filter = [], ?string $search = null)
    {
        return function ($query) use ($search) {
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('slug', 'like', '%' . $search . '%')
                        ->orWhereHas('products', function ($productQuery) use ($search) {
                            $productQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('slug', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('blogs', function ($blogQuery) use ($search) {
                            $blogQuery->where('title', 'like', '%' . $search . '%')
                                        ->orWhere('content', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('creator', function ($creatorQuery) use ($search) {
                            $creatorQuery->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('username', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            });
        };
    };
}}

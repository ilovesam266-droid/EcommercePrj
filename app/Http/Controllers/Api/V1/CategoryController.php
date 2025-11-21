<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Category\StoreCategoryRequest;
use App\Http\Requests\Api\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryDetailsTransformer;
use App\Http\Resources\CategoryTransformer;
use App\Http\Resources\ProductTransformer;
use App\Repository\Constracts\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends BaseApiController
{
    protected CategoryRepositoryInterface $categoryRepo;

    public function __construct(CategoryRepositoryInterface $category_repo)
    {
        parent::__construct();
        $this->categoryRepo = $category_repo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->searchFilterPerpage($request);
        $categories = $this->categoryRepo->getAllCategories($this->perPage, $this->sort, $this->filter, $this->search);

        if ($categories->isEmpty()) {
            return $this->error('No category is displayed');
        }

        return $this->paginate(CategoryTransformer::collection($categories), 'Category list retrived successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = Auth::id();
        $category = $this->categoryRepo->create($validated);
        if (!$category) {
            return $this->error('Category created failed');
        }

        return $this->success($category, 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $id)
    {
        $this->searchFilterPerpage($request);

        $category = $this->categoryRepo->find($id, ['products']);
        $products = $this->paginate(ProductTransformer::collection($category->products()->paginate($this->perPage)), 'Product of this category retrived successfully.');
        if (!$category) {
            return $this->error('No category exists');
        }
        if (!$products) {
            return $this->error('No products exists');
        }

        return $this->success(new CategoryDetailsTransformer($category, $products), 'Category retrived successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $validated = $request->validated();
        $category = $this->categoryRepo->update($id, $validated);
        if (!$category) {
            return $this->error('Category updated failed');
        }

        return $this->success($category, 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $category = $this->categoryRepo->delete($id);
        if ($category == false) {
            return $this->error('Category deleted failed');
        }

        return $this->success($category, 'Category deleted successfully');
    }
}

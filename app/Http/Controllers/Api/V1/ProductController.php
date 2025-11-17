<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\StoreProductRequest;
use App\Http\Requests\Api\Product\UpdateProductRequest;
use App\Http\Resources\ProductTransformer;
use App\Repository\Constracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\info;

class ProductController extends Controller
{
    protected ProductRepositoryInterface $productRepository;
    protected $perPage;
    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepository = $productRepo;
        $this->perPage = config('app.per_page');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productRepository->all(
            [],
            ['created_at' => 'asc'],
            $this->perPage,
            ['*'],
            [
                'images' => function ($query) {
                    $query->wherePivot('is_primary', true);
                },
                'categories',
                'reviews' => function ($query) {
                    $query->select('product_id', 'rating');
                },
                'creator'
            ],
            false
        );
        return response()->json(
            [
                'data' => ProductTransformer::collection($products),
                'meta' => [
                    'current_page' => $products->currentPage(),
                    'last_page'    => $products->lastPage(),
                    'per_page'     => $products->perPage(),
                    'total'        => $products->total(),
                ]
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $productData = $request->only([
            'name',
            'slug',
            'description',
            'status',
            'created_by',
        ]);
        $product = $this->productRepository->create($productData);
        if (!empty($request->selectedCategories)) {
            $product->categories()->sync($request->selectedCategories);
        }
        if (!empty($request->image_ids)) {
            $imagePivotData = [];
            foreach ($request->image_ids as $index => $image) {
                $imagePivotData[$image] = [
                    'is_primary' => $index == 0,
                    'order_of_images' => $index,
                ];
            }
            $product->images()->sync($imagePivotData);
        }
        return response()->json(
            [
                'data' => new ProductTransformer($product)
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $product = $this->productRepository->find($id);
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        $product = $request->only([
            'name',
            'slug',
            'description',
            'status',
        ]);
        $product = $this->productRepository->update($id, $product);
            if ($request->filled('selectedCategories')) {
                $product->categories()->sync($request->selectedCategories);
            }
            if ($request->filled('image_ids')) {
                $imagePivotData = [];
                foreach ($request->image_ids as $index => $image) {
                    $imagePivotData[$image] = [
                        'is_primary' => $index == 0,
                        'order_of_images' => $index,
                    ];
                }
                $product->images()->sync($imagePivotData);
        }
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $product = $this->productRepository->delete($id);
        return response()->json($product, 200);
    }
}

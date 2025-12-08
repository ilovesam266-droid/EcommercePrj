<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Product\StoreProductRequest;
use App\Http\Requests\Api\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductDetailsTransformer;
use App\Http\Resources\ProductTransformer;
use App\Http\Resources\ProductVariantTransformer;
use App\Repository\Constracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\info;

class ProductController extends BaseApiController
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        parent::__construct();
        $this->productRepository = $productRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->searchFilterPerpage($request);

        $products = $this->productRepository->getAllProducts($this->perPage, $this->sort, $this->search, $this->filter);
        if ($products->isEmpty()){
            return $this->error("No product retrived.");
        }

        return $this->paginate(ProductTransformer::collection($products), 'Product list retrived successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $productData = $request->validated();
        $productData['created_by'] = Auth::id();
        $product = $this->productRepository->create($productData);
        if (!$product){
            return $this->error('Product is not created');
        }

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

        return $this->success(new ProductTransformer($product), "Product is created successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $id)
    {
        $this->searchFilterPerpage($request);

        $products = $this->productRepository->getProduct($id);
        $variants = $this->paginate(ProductVariantTransformer::collection($products->variant_sizes()->paginate($this->perPage)), 'Variant retrived successfully.');

        return $this->success(new ProductDetailsTransformer($products, $variants), "Product retrived successfully", 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        $product = $request->validated();
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
        if (!$product){
            return $this->error('Product updated failed.');
        }

        return $this->success($product, 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $product = $this->productRepository->delete($id);
        if(!$product){
            return $this->error('Product deleted failed.');
        }

        return $this->success($product, 'Product deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Variant\StoreVariantRequest;
use App\Http\Requests\Api\Variant\UpdateVariantRequest;
use App\Http\Resources\ProductVariantTransformer;
use App\Repository\Constracts\ProductRepositoryInterface;
use App\Repository\Constracts\ProductVariantSizeRepositoryInterface;
use Illuminate\Http\Request;
use Throwable;

class ProductVariantController extends BaseApiController
{
    protected ProductVariantSizeRepositoryInterface $productVariantRepo;
    protected ProductRepositoryInterface $productRepo;

    public function __construct(ProductRepositoryInterface $product_repo, ProductVariantSizeRepositoryInterface $variant_repo)
    {
        parent::__construct();
        $this->productRepo = $product_repo;
        $this->productVariantRepo = $variant_repo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, int $productId)
    {
        $this->searchFilterPerpage($request);
        $product = $this->productRepo->find($productId, ['variant_sizes']);
        if(!$product){
            return $this->error('This product is not exist');
        }

        $variants = $product->variant_sizes;
        return $this->success($variants, 'Variant list retrived successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVariantRequest $request, int $productId)
    {
        $product = $this->productRepo->find($productId);
        if(!$product){
            return $this->error('This product is not exist');
        }

        $variantData = $request->validated();

        try{
            $variant = $product->variant_sizes()->create($variantData);
        }catch(Throwable $e){
            return $this->error('This product variant is already exists');
        }

        if (!$variant){
            return $this->error('Product variant is not created');
        }

        return $this->success(new ProductVariantTransformer($variant), 'Product variant is created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $productId, int $variantId)
    {
        $product = $this->productRepo->find($productId);
        if (!$product){
            return $this->error('Product is not exists');
        }

        $variant = $product->variant_sizes()->find($variantId);
        if (!$variant){
            return $this->error('Product is not exists');
        }

        return $this->success(new ProductVariantTransformer($variant), 'Product variant retrived successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVariantRequest $request, int $productId, int $variantId)
    {
        $validated = $request->validated();

        try{
            $variant = $this->productVariantRepo->update($variantId, $validated);
        }catch(Throwable $e){
            return $this->error('Variant is already exist');
        }

        if (!$variant){
            return $this->error('Variant is not updated');
        }

        return $this->success(new ProductVariantTransformer($variant), 'Product variant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $productId, int $variantId)
    {
        $variant = $this->productVariantRepo->delete($variantId);
        if ($variant == false){
            return $this->error('Delete Failed');
        }

        return $this->success($variant, 'Product variant deleted successfully.');
    }
}

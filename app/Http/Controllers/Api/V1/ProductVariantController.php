<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Variant\StoreVariantRequest;
use App\Http\Requests\Api\Variant\UpdateVariantRequest;
use App\Http\Resources\ProductVariantTransformer;
use App\Repository\Constracts\ProductVariantSizeRepositoryInterface;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    protected ProductVariantSizeRepositoryInterface $productVariantRepo;
    protected $perPage;
    public function __construct(ProductVariantSizeRepositoryInterface $variantRepo)
    {
        $this->productVariantRepo = $variantRepo;
        $this->perPage = config('app.per_page');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variants = $this->productVariantRepo->all([], ['created_at' => 'asc'], $this->perPage, ['*'], [], false);
        return response()->json(
            [
                "message" => "Product list retrieved successfully.",
                'data' => ProductVariantTransformer::collection($variants),
                'meta' => [
                    'current_page' => $variants->currentPage(),
                    'last_page'    => $variants->lastPage(),
                    'per_page'     => $variants->perPage(),
                    'total'        => $variants->total(),
                ]
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVariantRequest $request)
    {
        $variantData = $request->validated();
        $variant = $this->productVariantRepo->create($variantData);
        return response()->json([
            "message" => "Product variant created successfully.",
            'data' => new ProductVariantTransformer($variant),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $variant = $this->productVariantRepo->find($id);
        return response()->json([
            "message" => "Product variant retrieved successfully.",
            "data" => new ProductVariantTransformer($variant),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVariantRequest $request, int $id)
    {
        $validated = $request->validated();
        $variant = $this->productVariantRepo->update($id, $validated);
        return response()->json([
            "message" => "Product variant retrieved successfully.",
            "data" => new ProductVariantTransformer($variant),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $variant = $this->productVariantRepo->delete($id);
        return response()->json([
            "message" => "Product variant deleted successfully."
        ], 200);
    }
}

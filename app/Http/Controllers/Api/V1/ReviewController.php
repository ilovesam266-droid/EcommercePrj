<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\ReviewTransformer;
use App\Models\Review;
use App\Repository\Constracts\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ReviewController extends BaseApiController
{
    protected ProductRepositoryInterface $productRepo;

    public function __construct(ProductRepositoryInterface $product_repo)
    {
        parent::__construct();
        $this->productRepo = $product_repo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, int $productId)
    {
        $this->searchFilterPerpage($request);
        $product = $this->productRepo->find((int)$productId, ['reviews']);
        if (!$product){
            return $this->error('Product is not exist');
        }

        $reviews = $product->reviews();
        if (!$reviews){
            return $this->error('Review is not exist');
        }
        return $this->paginate(ReviewTransformer::collection($reviews->paginate($this->perPage)), 'Review retrived successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

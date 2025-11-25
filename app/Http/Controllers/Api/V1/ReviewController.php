<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ReviewStatus;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Review\ReviewProductRequest;
use App\Http\Resources\Product\ProductReviewsTransformer;
use App\Http\Resources\ReviewTransformer;
use App\Models\Review;
use App\Repository\Constracts\ProductRepositoryInterface;
use App\Repository\Constracts\ReviewRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends BaseApiController
{
    protected ProductRepositoryInterface $productRepo;
    protected ReviewRepositoryInterface $reviewRepo;

    public function __construct(ProductRepositoryInterface $product_repo, ReviewRepositoryInterface $review_repo)
    {
        parent::__construct();
        $this->productRepo = $product_repo;
        $this->reviewRepo = $review_repo;
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

        $reviews = $this->paginate(ReviewTransformer::collection($product->reviews()->paginate($this->perPage)), 'Review retrived successfully.');
        if (!$reviews){
            return $this->error('Review is not exist');
        }

        return $this->success( new ProductReviewsTransformer($product, $reviews), 'Product retrived successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewProductRequest $request, int $productId)
    {
        $validated = $request->validated();
        $validated['product_id'] = $productId;
        $validated['user_id'] = Auth::id();
        $validated['status'] = ReviewStatus::Approved;

        if ($this->reviewRepo->isExists(Auth::id(), $productId, $request->order_id)){
            return $this->error('You already reviewed this product');
        }

        $review = $this->reviewRepo->create($validated);
        if (!$review){
            return $this->error('Review created failed.');
        }

        return $this->success(new ReviewTransformer($review), 'Review created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function myReviews(Request $request)
    {
        $this->searchFilterPerpage($request);
        $reviews = ReviewTransformer::collection($this->reviewRepo->getReviewByUser(Auth::id())->paginate($this->perPage));

        return $this->paginate($reviews, 'Your review is displaying');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $reviewId)
    {
        if ($this->reviewRepo->getReviewByUser(Auth::id())->where('id', $reviewId)){
            $review = $this->reviewRepo->delete((int) $reviewId);
            if ($review == false) {
                return $this->error('Review deleted failed.');
            }
            return $this->success($review, 'Review deleted successfully.');
        }
    }
}

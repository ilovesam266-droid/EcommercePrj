<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Address\StoreAddressRequest;
use App\Http\Requests\Api\Address\UpdateAddressRequest;
use App\Http\Resources\AddressTransformer;
use App\Repository\Constracts\AddressRepositoryInterface;
use Illuminate\Http\Request;

class AddressController extends BaseApiController
{
    protected AddressRepositoryInterface $addressRepo;
    protected $perPage;
    protected $sort;

    public function __construct(AddressRepositoryInterface $address_repo)
    {
        $this->addressRepo = $address_repo;
        $this->perPage = config('app.per_page');
        $this->sort = config('app.sort');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $perPage = min($request->get('per_page', 20), 50);
        $addresses = $this->addressRepo->all([], ['created_at' => $this->sort], $this->perPage, ['*'], [], false);
        return $this->paginate(AddressTransformer::collection($addresses), "Address list retrived successfully.", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $validated = $request->validated();
        $address = $this->addressRepo->create($validated);
        return $this->success($address, "Address is created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $address = $this->addressRepo->find($id);
        if (!$address){
            return $this->error('Not exists this address');
        }

        return $this->success($address, "Address retrived successfully.");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, int $id)
    {
        $validated = $request->validated();
        $address = $this->addressRepo->update($id, $validated);

        return $this->success($address, "Address is updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $address = $this->addressRepo->delete($id);

        return $this->success()
    }
}

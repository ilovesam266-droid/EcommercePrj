<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Address\StoreAddressRequest;
use App\Http\Requests\Api\Address\UpdateAddressRequest;
use App\Http\Resources\AddressTransformer;
use App\Repository\Constracts\AddressRepositoryInterface;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class AddressController extends BaseApiController
{
    protected AddressRepositoryInterface $addressRepo;

    public function __construct(AddressRepositoryInterface $address_repo)
    {
        parent::__construct();
        $this->addressRepo = $address_repo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->searchFilterPerpage($request);

        $addresses = $this->addressRepo->all(
            $this->addressRepo->getFilteredAddress(
            $this->filter, $this->search), ['created_at' => $this->sort], $this->perPage, ['*'], [], false);
        if ($addresses->isEmpty()) {
            return $this->error("No address retrived.");
        }

        return $this->paginate(AddressTransformer::collection($addresses), "Address list retrived successfully.", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $validated = $request->validated();
        $address = $this->addressRepo->create($validated);
        if (!$address){
            return $this->error('Address is not created');
        }

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
        if (!$address){
            return $this->error('Address is not updated');
        }

        return $this->success($address, "Address is updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $address = $this->addressRepo->delete($id);
        if ($address == false){
            return $this->error('Delete Failed');
        }

        return $this->success($address, "Address is deleted successfully.");
    }
}

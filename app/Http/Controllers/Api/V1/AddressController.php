<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Address\StoreAddressRequest;
use App\Http\Requests\Api\Address\UpdateAddressRequest;
use App\Http\Resources\AddressTransformer;
use App\Repository\Constracts\AddressRepositoryInterface;
use App\Repository\Constracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;

class AddressController extends BaseApiController
{
    protected AddressRepositoryInterface $addressRepo;
    protected UserRepositoryInterface $userRepo;

    public function __construct(AddressRepositoryInterface $address_repo, UserRepositoryInterface $user_repo)
    {
        parent::__construct();
        $this->addressRepo = $address_repo;
        $this->userRepo = $user_repo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->searchFilterPerpage($request);

        $user = $this->userRepo->find(Auth::id());
        $addresses = $user->addresses;
        if ($addresses->isEmpty()) {
            return $this->error("No address retrived.");
        }

        return $this->success($addresses, 'Address list retrived successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $user = $this->userRepo->find(Auth::id());
        $validated = $request->validated();

        $address = $user->addresses()->create($validated);
        if (!$address){
            return $this->error('Address is not created');
        }

        return $this->success(new AddressTransformer($address), "Address is created successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = $this->userRepo->find(Auth::id());
        $address = $user->addresses()->find($id);
        if (!$address){
            return $this->error('Not exists this address');
        }

        return $this->success(new AddressTransformer($address), "Address retrived successfully.");
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

        return $this->success(new AddressTransformer($address), "Address is updated successfully.");
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

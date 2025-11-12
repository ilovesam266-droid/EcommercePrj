<?php

namespace App\Livewire\Admin\Address;

use App\Http\Requests\AddressRequest;
use App\Repository\Constracts\AddressRepositoryInterface;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class EditAddress extends Component
{
    protected AddressRepositoryInterface $addressRepository;
    protected AddressRequest $addressRequest;
    public $addressId = null;
    public $recipient_name;
    public $recipient_phone;
    public $province;
    public $district;
    public $ward;
    public $detailed_address;
    public $is_default;
    public $user_id;

    public function __construct()
    {
        $this->addressRequest = new AddressRequest();
    }

    public function boot(AddressRepositoryInterface $repository)
    {
        $this->addressRepository = $repository;
    }

    public function rules()
    {
        return $this->addressRequest->rules();
    }
    public function messages()
    {
        return $this->addressRequest->messages();
    }

    public function mount($addressId)
    {
        $this->addressId = $addressId;
        $this->loadAddress();
    }

    public function loadAddress()
    {
        $address = $this->addressRepository->find($this->addressId);
        if ($address) {
            $this->fill($address->only([
                'user_id',
                'recipient_name',
                'recipient_phone',
                'province',
                'district',
                'ward',
                'detailed_address',
                'is_default',
            ]));
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'Cant find out this address');
        }
    }

    public function editAddress()
    {
        $this->validate();
        $addressData = $this->only([
            'recipient_name',
            'recipient_phone',
            'province',
            'district',
            'ward',
            'detailed_address',
        ]);
        $addressData['is_default'] = $this->is_default ? 1 : 0;

        $success = $this->addressRepository->update($this->addressId, $addressData);

        if ($success) {
            $this->dispatch('addressUpdated');
            $this->dispatch('showToast', 'success', 'Success', 'Address is updated successfully');
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'Some errors occur when updating address');
        }
    }

    #[Layout('layouts.page-layout')]
    #[Title('Edit Address')]
    public function render()
    {
        return view('admin.pages.address.edit');
    }
}

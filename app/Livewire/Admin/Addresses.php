<?php

namespace App\Livewire\Admin;

use App\Repository\Constracts\AddressRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Addresses extends Component
{
    use WithPagination;

    protected AddressRepositoryInterface $addressRepository;
    public string $search = '';
    public array $filter = [
        'is_default' => '',
    ];
    public $sort;
    public $perPage;
    public bool $showEditModal = false;
    public $editingAddressId = null;


    public function boot(AddressRepositoryInterface $address_repository)
    {
        $this->addressRepository = $address_repository;
    }

    public function mount(){
        $this->sort = config('app.sort');
        $this->perPage = config('app.per_page');
    }

    public function confirmDelete($addressId){
        $this->dispatch(
            'showConfirm',
            'Confirm address deletion',
            'Are you sure you want to delete this address <<#ADR'.$addressId.'>>?',
            'delete-address',
            ['address_id' => $addressId],
        );
    }

    #[On('delete-address')]
    public function deleteAddress($data)
    {
        $addressId = $data['address_id'];
        $this->addressRepository->delete($addressId);
        $this->dispatch('showToast', 'success', 'Success','address Deleted');
    }

    public function setAsDefault($addressId)
    {
        $address = $this->addressRepository->update($addressId, ['is_default' => true]);
        if ($address) {
            $this->dispatch('showToast', 'success', 'Success', 'This address is setted default');
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'This address is not setted default');
        }
    }

    public function openEditModal($addressId)
    {
        $this->editingAddressId = $addressId;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['editingAddressId']);
    }


    #[On('searchPerformed')]
    public function updatedSearchTemp($searchTemp)
    {
        $this->search = $searchTemp;
    }

    #[On('filterPerformed')]
    public function updatedSelectedFilter($selectedFilter)
    {
        $this->filter = array_merge($this->filter, $selectedFilter);
    }

    //after search
    #[On('resetPage')]
    public function Search()
    {
        $this->resetPage();
    }

    #[Computed()]
    public function addresses()
    {
        return $this->addressRepository->getAllAddress($this->perPage, $this->sort, $this->search, $this->filter);
    }

    #[Layout('layouts.page-layout')]
    #[Title('Addresses')]
    public function render()
    {
        $addressFiltersConfig = [
            [
                'key' => 'is_default',
                'placeholder' => 'Filter by Default Status',
                'options' => [
                    ['label' => 'Default Address', 'value' => '1'],
                    ['label' => 'Non-default Address', 'value' => '0'],
                ],
            ],
        ];
        $totalDefault = $this->addressRepository->getDefault();
        $missingField = $this->addressRepository->countMissingFields();
        $topProvinces = $this->addressRepository->topProvinces();

        return view('admin.pages.addresses', compact('addressFiltersConfig', 'totalDefault', 'missingField', 'topProvinces'));
    }
}

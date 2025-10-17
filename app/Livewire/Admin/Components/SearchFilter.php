<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;

class SearchFilter extends Component
{

    public string $searchTemp = '';
    public array $selectedFilter = [];
    public array $filterConfigs = [];
    public string $placeholderSearch = '';

    public function mount( array $filterConfigs){
        $this->filterConfigs = $filterConfigs;
    }

    public function updatedSearchTemp(){
        $this->dispatch('searchPerformed', $this->searchTemp);
    }

    public function updatedSelectedFilter(){
        $this->dispatch('filterPerformed', $this->selectedFilter);
    }

    public function btnSearch(){
        $this->dispatch('resetPage');
    }

    public function render()
    {
        return view('admin.components.search-filter');
    }
}

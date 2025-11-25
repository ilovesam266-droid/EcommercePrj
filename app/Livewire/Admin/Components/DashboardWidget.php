<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;

class DashboardWidget extends Component
{
    public $title;
    public $value;
    public $color;
    public $icon;
    public $subtext;
    public $chartId;
    public $dropdownItems = [];

    public function mount($title, $value, $color = 'primary', $icon = null, $subtext = null, $chartId = null, $dropdownItems = [])
    {
        $this->title = $title;
        $this->value = $value;
        $this->color = $color;
        $this->icon = $icon;
        $this->subtext = $subtext;
        $this->chartId = $chartId;
        $this->dropdownItems = $dropdownItems;
    }

    public function render()
    {
        return view('admin.components.dashboard-widget');
    }
}

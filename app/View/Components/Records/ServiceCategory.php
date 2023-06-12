<?php

namespace App\View\Components\Records;

use Illuminate\View\Component;

class ServiceCategory extends Component
{
    public $serviceCategory;
    public $admin;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($serviceCategory, $admin = '')
    {
        $this->serviceCategory = $serviceCategory;
        $this->admin = $admin;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.records.service-category');
    }
}

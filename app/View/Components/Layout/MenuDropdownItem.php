<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;

class MenuDropdownItem extends Component
{
    public $link;
    public $hr;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($link = '', $hr = '')
    {
        $this->link = $link;
        $this->hr = $hr;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.menu-dropdown-item');
    }
}

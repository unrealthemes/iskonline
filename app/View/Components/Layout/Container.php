<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;

class Container extends Component
{
    public $fluid;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fluid = '')
    {
        $this->fluid = $fluid;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.container');
    }
}

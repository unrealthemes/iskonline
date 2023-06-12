<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;

class Section extends Component
{
    public $bg;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($bg = "")
    {
        $this->bg = $bg;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.section');
    }
}

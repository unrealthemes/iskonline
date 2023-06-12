<?php

namespace App\View\Components\Blocks;

use Illuminate\View\Component;

class CarouselItem extends Component
{
    public $active;
    public $period;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($active = '', $period = 0)
    {
        $this->active = $active;
        $this->period = $period;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.blocks.carousel-item');
    }
}

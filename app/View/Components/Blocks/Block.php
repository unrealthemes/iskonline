<?php

namespace App\View\Components\Blocks;

use Illuminate\View\Component;

class Block extends Component
{
    public $bg;
    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($bg = '', $class = '')
    {
        $this->bg = $bg;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.blocks.block');
    }
}

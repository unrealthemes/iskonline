<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class CardHeader extends Component
{
    public $color;
    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($color = '', $class = '')
    {
        $this->color = $color;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card.card-header');
    }
}

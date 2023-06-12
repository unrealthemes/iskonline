<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;

class MenuDropdown extends Component
{
    public $text;
    public $btn;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text, $btn = false)
    {
        $this->text = $text;
        $this->btn = $btn;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.menu-dropdown');
    }
}

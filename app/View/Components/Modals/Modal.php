<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class Modal extends Component
{
    public $title;
    public $id;
    public $size;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title, $size = "lg")
    {
        $this->id = $id;
        $this->title = $title;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modals.modal');
    }
}

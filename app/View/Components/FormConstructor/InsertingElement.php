<?php

namespace App\View\Components\FormConstructor;

use Illuminate\View\Component;

class InsertingElement extends Component
{
    public $parents;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($parents = false)
    {
        $this->parents = $parents;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-constructor.inserting-element');
    }
}

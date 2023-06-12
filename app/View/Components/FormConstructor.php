<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormConstructor extends Component
{
    public $formId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($formId)
    {
        $this->formId = $formId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-constructor');
    }
}

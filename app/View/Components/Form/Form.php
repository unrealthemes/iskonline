<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Form extends Component
{
    public $action;
    public $method;
    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($action, $method = "POST", $class = '')
    {
        $this->action = $action;
        $this->method = $method;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.form');
    }
}

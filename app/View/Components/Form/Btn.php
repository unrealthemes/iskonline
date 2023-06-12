<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Btn extends Component
{
    public $class;
    public $color;
    public $link;
    public $role;
    public $disabled;
    public $confirmText;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($color = 'primary', $class = '', $link = '', $role = 'submit', $disabled = '', $confirmText = "")
    {
        $this->color = $color;
        $this->class = $class;
        $this->link = $link;
        $this->role = $role;
        $this->disabled = $disabled;
        $this->confirmText = $confirmText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.btn');
    }
}

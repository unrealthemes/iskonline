<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $label;
    public $name;
    public $value;
    public $type;
    public $multiple;
    public $formFloating;
    public $class;
    public $suggestions;
    public $required;
    public $rows;
    public $placeholder;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$placeholder = '',$label, $value = "", $type = "text", $multiple = "0", $formFloating = '', $class = '', $suggestions = '', $required = false, $rows = 3)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->type = $type;
        $this->multiple = $multiple;
        $this->formFloating = $formFloating;
        $this->class = $class;
        $this->suggestions = $suggestions;
        $this->required = $required;
        $this->rows = $rows;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input');
    }
}

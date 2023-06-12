<?php

namespace App\View\Components\Accordion;

use Illuminate\View\Component;

class AccordionItem extends Component
{
    public $i;
    public $text;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text, $i)
    {
        $this->text = $text;
        $this->i = $i;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.accordion.accordion-item');
    }
}

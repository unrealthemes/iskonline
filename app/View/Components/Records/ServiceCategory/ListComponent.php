<?php

namespace App\View\Components\Records\ServiceCategory;

use Illuminate\View\Component;

class ListComponent extends Component
{
    public $record;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record)
    {
        $this->record = $record;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.records.service-category.list-component');
    }
}

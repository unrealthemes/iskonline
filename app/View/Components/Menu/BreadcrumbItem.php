<?php

namespace App\View\Components\Menu;

use Illuminate\View\Component;

class BreadcrumbItem extends Component
{
    public $link;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($link)
    {
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu.breadcrumb-item');
    }
}

<?php

namespace App\View\Components\Service;

use Illuminate\View\Component;

class ServiceComponent extends Component
{
    public $service;
    public $color;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($service)
    {
        $this->service = $service;

        $colors = [
            'orange', 'violet', 'green', 'blue', 'pink', 'yellow', 'light-green', 'gray'
        ];
        $this->color = $colors[$service->id % count($colors)];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.service.service-component');
    }
}

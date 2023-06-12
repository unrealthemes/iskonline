<?php

namespace App\View\Components\Service;

use App\Models\Service;
use Illuminate\View\Component;

class ServicesList extends Component
{
    public $showAll;
    public $records;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($showAll = false)
    {
        $this->showAll = $showAll;
        $this->records = $showAll ? Service::where("rating", ">=", 0)->orderBy('rating', 'desc')->get() : Service::where("rating", ">=", 0)->orderBy('rating', 'desc')->take(10)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.service.services-list');
    }
}

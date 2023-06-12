<?php

namespace App\View\Components\Tabs;

use Illuminate\View\Component;

class TabsButton extends Component
{
    public $tabId;
    public $contentId;
    public $active;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tabId, $contentId, $active = '')
    {
        $this->tabId = $tabId;
        $this->contentId = $contentId;
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tabs.tabs-button');
    }
}

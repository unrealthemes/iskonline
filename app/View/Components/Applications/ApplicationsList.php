<?php

namespace App\View\Components\Applications;

use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class ApplicationsList extends Component
{
    public $records;
    public $statuses;
    public $services;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $user = Auth::user();
        $this->records = Application::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->where('confirmed', '=', true)->get();
        $this->statuses = ApplicationStatus::get()->keyBy('id');
        $this->services = Service::get()->keyBy('id');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.applications.applications-list');
    }
}

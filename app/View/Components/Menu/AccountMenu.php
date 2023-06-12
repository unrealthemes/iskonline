<?php

namespace App\View\Components\Menu;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class AccountMenu extends Component
{
    public $user;
    public $auth;
    public $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->auth = false;
        if (Auth::check()) {
            $this->auth = true;
            $this->user = Auth::user();
            if ($this->user->name) {
                $this->name = isset(explode(" ", $this->user->name)[1]) ? explode(" ", $this->user->name)[1] : $this->user->name;
            } else {
                $this->name = $this->user->tel;
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu.account-menu');
    }
}

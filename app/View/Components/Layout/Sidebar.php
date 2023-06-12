<?php

namespace App\View\Components\Layout;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public $user;
    public $pages;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Auth::user();
        $this->pages = [
            ['Главная', 'admin.index'],
            // ['Категории', 'admin.service_categories.index'],
            // ['Калькуляторы', 'admin.services'],
            ['Заявления', 'admin.applications.index'],
            ['Формы', 'admin.forms.forms.index'],
            ['Сервисы', 'admin.services.index'],
            ['Страницы', 'admin.blog.index'],
        ];

        $curRouteName = Route::currentRouteName();
        $routeElements = explode('.', $curRouteName);
        $end = $routeElements[count($routeElements) - 1];
        if (in_array($end, ['create', 'edit'])) {
            $routeElements[count($routeElements) - 1] = 'index';
            $curRouteName = implode('.', $routeElements);
        }

        foreach ($this->pages as $key => $page) {
            if ($curRouteName == $page[1]) {
                $this->pages[$key][2] = true;
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
        return view('components.layout.sidebar');
    }
}

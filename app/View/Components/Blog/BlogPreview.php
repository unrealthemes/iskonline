<?php

namespace App\View\Components\Blog;

use Illuminate\View\Component;

class BlogPreview extends Component
{
    public $blog;
    public $date;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($blog)
    {
        $this->blog = $blog;

        $arr = [
            'января',
            'февраля',
            'марта',
            'апреля',
            'мая',
            'июня',
            'июля',
            'августа',
            'сентября',
            'октября',
            'ноября',
            'декабря'
        ];

        // Поскольку от 1 до 12, а в массиве, как мы знаем, отсчет идет от нуля (0 до 11),
        // то вычитаем 1 чтоб правильно выбрать уже из нашего массива.

        $month = date('n', strtotime($this->blog->created_at)) - 1;
        $this->date = date("d $arr[$month] Y", strtotime($this->blog->created_at));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.blog.blog-preview');
    }
}

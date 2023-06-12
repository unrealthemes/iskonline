<?php

namespace App\View\Components\Blog;

use App\Models\Blog;
use Illuminate\View\Component;

class BlogList extends Component
{
    public $blog;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($except = -1, $limit = 4)
    {
        $this->blog = Blog::where('id', '!=', $except)->orderBy('created_at', 'DESC')->limit($limit > 0 ? $limit : 64)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.blog.blog-list');
    }
}

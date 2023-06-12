<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\FormUiForm;
use Illuminate\Http\Request;

class BlogController extends Controller
{
   
    public function index()
    {
        $pages = Blog::get();
        return view('pages-admin.blog.index', ['blog' => $pages]);
    }

  
    public function create()
    {
        return view('pages-admin.blog.create');
    }

   
    public function store(Request $request)
    {
        $filename = md5($request->preview->getClientOriginalName()) . "." . $request->preview->extension();
        $request->preview->storeAs('public/blog', $filename);
        $data = $request->all();
        $data['preview'] = asset('storage/blog/' . $filename);

        $checkboxes = ['show_author_block', 'show_form_block', 'show_share_block'];

        foreach ($checkboxes as $key) {
            $data[$key] = isset($data[$key]) ? 1 : 0;
        }

        $blog = Blog::create($data);

        return redirect()->to(route('admin.blog.index'));
    }

  
    public function show(Request $request)
    {
        $routeName = $request->route()->getName();
        $id = explode('.', $routeName)[2];
        $page = Blog::find($id);

        $text = $page->text;
        $token = csrf_field();

        foreach (FormUiForm::get() as $form) {
            $text = str_replace("[form=$form->id]", "<div class='my-3' data-init-form='$form->id'>$token</div>", $text);
        }

        return view('pages.blog-page', ['blog' => $page, 'text' => $text]);
    }

    public function edit(Blog $blog)
    {
        return view('pages-admin.blog.edit', ['blog' => $blog]);
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->all();
        if ($request->preview) {
            $filename = md5($request->preview->getClientOriginalName()) . "." . $request->preview->extension();
            $request->preview->storeAs('public/blog', $filename);
            $data['preview'] = asset('storage/blog/' . $filename);
        }


        $checkboxes = ['show_author_block', 'show_form_block', 'show_share_block'];

        foreach ($checkboxes as $key) {
            $data[$key] = isset($data[$key]) ? 1 : 0;
        }

        $blog->update($data);

        return redirect()->to(route('admin.blog.index'));
    }

    public function delete(Blog $blog)
    {
        $blog->delete();

        return redirect()->to(route('admin.blog.index'));
    }
}

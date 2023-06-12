<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminFormsController extends Controller
{
    public function index()
    {
        return view("pages-admin.forms.index");
    }
}

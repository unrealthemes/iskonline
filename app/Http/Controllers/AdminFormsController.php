<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminFormsController extends Controller
{
    public function index()
    {
        return view("pages-admin.forms.index");
    }
}

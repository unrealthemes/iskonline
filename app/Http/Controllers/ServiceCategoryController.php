<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public $info = [
        'title' => 'Категории',
        'table' => 'service_categories',
        'list_component' => 'service-category',
        'record_name' => 'serviceCategory',
        'record_title_column' => 'name',
        'columns' => [
            [
                'name' => 'name',
                'label' => 'Название',
                'type' => 'text'
            ],
            [
                'name' => 'description',
                'label' => 'Описание',
                'type' => 'textarea'
            ]
        ],
        'breadcrumbs' => []
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = ServiceCategory::get();

        return view('pages-admin.crud.records-page', ['records' => $records, 'info' => $this->info]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('pages-admin.crud.create-page', ['info' => $this->info]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ServiceCategory::create($request->all());

        return redirect()->to(route("admin." . $this->info['table'] . ".index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceCategory $serviceCategory)
    {

        return view('pages-admin.crud.edit-page', ['info' => $this->info, 'record' => $serviceCategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        $serviceCategory->delete();

        return redirect()->to(route("admin." . $this->info['table'] . ".index"));
    }
}

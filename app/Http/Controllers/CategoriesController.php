<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;
use App\Models\Categories;
use App\Services\CrudService;
use Illuminate\Http\Client\Request;

class CategoriesController extends Controller
{
    protected $crudService;

    public function __construct() {
        $this->crudService = new CrudService(new Categories);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->crudService->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriesRequest $request)
    {
        $data = $request->input();
        $toSave = [
            'code' => 'CAT00' . rand(10,50),
            'title' => $data['title'],
            'sort' => Categories::count() + 1,
            'created_by' => 1
        ];
        if($request->has("bgColor")) $toSave['bgColor'] = $data['bgColor'];
        if($request->has("textColor")) $toSave['textColor'] = $data['textColor'];
        $response = $this->crudService->store($toSave);
        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->crudService->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriesRequest $request, int $id)
    {
        return $this->crudService->update($request , $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->crudService->destroy($id);
    }
}

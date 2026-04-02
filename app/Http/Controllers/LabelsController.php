<?php

namespace App\Http\Controllers;

use App\Models\Labels;
use App\Services\CrudService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\JsonResponse;

class LabelsController extends Controller
{
    CONST CACHE_TIMER = 60;
    protected $crudService;

    public function __construct() {
        $this->crudService = new CrudService(new Labels);
    }
    /**
     * store new label
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->only('title');
            if(!$input){
                throw new \Exception("Missing title from payload");
            }
            $labelInfo = Labels::where('title',$input)->exists();
            if($labelInfo){
                throw new \Exception("{$input['title']} is already exists");
            }
            $labelCountIncr = Labels::count() + 1;
            $label = Labels::create([
                'code' => 'L00'. rand(10,50),
                'title' => $request->title,
                'sort' => $labelCountIncr
            ]);

            return $this->successResponse([
                'label' => $label
            ],'Successfully Created Label');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    /**
     * Display
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->crudService->index();
    }

   /**
     * Show the form for editing the specified resource.
     *
     *  @param  mixed $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
           return $this->crudService->show($id);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $label = $this->crudService->update($request,$id , true);
            $isAlreadyExist = Labels::where('title',$request->title)->exists();
            if($isAlreadyExist){
                throw new \Exception("{$request->title} is already exists");
            }

            $label->update($request->only('title'));
            return $this->successResponse($label,'Successfully updated');
        } catch (\Throwable $th) {
           return $this->errorResponse($th->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $data = $this->crudService->destroy($id);
            return $this->successResponse("",'Successfully Deleted');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}

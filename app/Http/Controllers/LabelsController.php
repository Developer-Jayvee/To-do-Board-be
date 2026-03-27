<?php

namespace App\Http\Controllers;

use App\Models\Labels;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\JsonResponse;

class LabelsController extends Controller
{
    CONST CACHE_TIMER = 60;
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

            $label = Labels::create([
                'code' => 'L004',
                'title' => $request->title,
                'sort' => Labels::count() + 1
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
        $labels = Labels::all()->collect();

        return $this->successResponse($labels);
    }

   /**
     * Show the form for editing the specified resource.
     */
    public function show(int $id)
    {
        try {
            $label = Labels::find($id);
            if(!$label){
                throw new \Exception('No data found.');
            }
            return $this->successResponse($label);
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
            $label = Labels::find($id);
            if(!$label){
                throw new \Exception('No data found.');
            }
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
            $label = Labels::find($id);
            if(!$label){
                throw new \Exception('No data found.');
            }
            $label->delete();
            return $this->successResponse("",'Successfully Deleted');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}

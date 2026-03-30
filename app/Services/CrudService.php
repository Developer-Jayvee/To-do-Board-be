<?php

namespace App\Services;

use App\Contract\CrudProvider;
use App\Models\Categories;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CrudService extends Services implements CrudProvider
{
    protected $model;
    public function __construct($model) {
        $this->model = $model;
    }
    /**
     * Display list
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            if(!$this->model){
                throw new \Exception("Model does not exist.");
            }
            $response = $this->model->all()->collect();
            return $this->successResponse($response);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    /**
     * Store new data
     *
     * @param  mixed $request
     * @return void
     */
    public function store(array $input)
    {
        try {
            if(!$this->model){
                throw new \Exception("Model does not exist.");
            }
            if(!$input){
                throw new \Exception("Missing payload");
            }

            $result = $this->model::create($input);
            return $this->successResponse($result);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    /**
     * Show existing data
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = self::checkModelIfExists($id);

            return $this->successResponse($result);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    /**
     * Delete existing data
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy(int $id)
    {
        try {
           $result = self::checkModelIfExists($id);
           $result?->delete();

           return $this->successResponse("","Successfully Deleted");
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    /**
     * Update existing data
     *
     * @param  mixed $request
     * @param  mixed $id
     * @param  mixed $isCustomUpdate
     * @return void
     */
    public function update(Request $request, int $id , bool $isCustomUpdate = false)
    {
        try {
            $input = $request->input();
            $data = self::checkModelIfExists($id);
            if(!$isCustomUpdate){
                $data?->update($input);
                return $this->successResponse($data);
            }
            return $data;
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    /**
     * Check if model exists
     *
     * @param  mixed $id
     * @return void
     */
    private function checkModelIfExists(int $id)
    {
        if(!$this->model){
            throw new \Exception("Model does not exist.");
        }
        $result = $this->model->find($id);
        if(!$result){
            throw new \Exception("No data found.");

        }
        return $result;
    }
}

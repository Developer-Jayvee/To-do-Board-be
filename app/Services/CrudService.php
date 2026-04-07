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
    protected bool $hasRelation = false;
    protected string | array $relation;
    public function __construct($model , bool $hasRelation = false , string | array $relation = "") {
        $this->model = $model;
        $this->hasRelation = $hasRelation;
        $this->relation = $relation;
    }

    /**
     * Display list
     *
     * @param  mixed $where
     * @return JsonResponse
     */
    public function index(array $where = array(),bool $isAsc = false): JsonResponse
    {
        try {
            if(!$this->model){
                throw new \Exception("Model does not exist.");
            }
            $response = $this->model->where($where);
            if($isAsc) $response = $response->orderBy('sort');
            if($this->hasRelation) $response = $response->with($this->relation);
            $response = $response->get()->collect();
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
    public function update(Request $request, int $id , bool $isCustomUpdate = false )
    {
        try {
            $input = $request->input();
            $data = self::checkModelIfExists($id);
            if(!$isCustomUpdate){
                $data?->update($input);
                return $this->returnResponse($data);
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
        $data = $this->model;
        if($this->hasRelation){
            $data = $data->with($this->relation);
        }

        $result = $data->find($id);
        if(!$result){
            throw new \Exception("No data found.");

        }
        return $result;
    }
    /**
     * returnResponse
     *
     * @param  mixed $modelInstance
     * @return void
     */
    private function returnResponse(mixed $modelInstance = null)
    {
        try {
            if(!$modelInstance){
                throw new \Exception("No model found");
            }

            if($this->hasRelation){
                return $this->successResponse($modelInstance->load($this->relation));
            }
            return $this->successResponse($modelInstance);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}

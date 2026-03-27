<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

trait ResponseTrait
{
    /**
     * successResponse
     *
     * @param  mixed $data
     * @param  mixed $message
     * @param  mixed $code
     * @return JsonResponse
     */
    protected function successResponse(array | string $data , string $message = 'Success' ,int $code = 200) : JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'sucess' => true
        ],$code);
    }
    /**
     * errorResponse
     *
     * @param  mixed $message
     * @param  mixed $code
     * @param  mixed $errors
     * @return JsonResponse
     */
    protected function errorResponse(string $message = 'Error' , int $code = 500 , array | null | string $errors = null):JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $errors
        ],$code);
    }
    /**
     * requestFailedResponse
     *
     * @param  mixed $validator
     * @return void
     */
    protected function requestFailedResponse(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'errors' => $errors->messages()
        ],500);
        throw new HttpResponseException($response);
    }

}

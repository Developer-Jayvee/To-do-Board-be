<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contract\AuthProvider;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    public $authService;

    public function __construct(AuthProvider $authService) {
        $this->authService = $authService;
    }
    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request): JsonResponse
    {
        $input = $request->only('username','password');
        return $this->authService->login($input);
    }
    /**
     * register
     *
     * @param  Request $request
     * @return void
     */
    public function register(Request $request): JsonResponse
    {
        return $this->authService->register($request);
    }
}

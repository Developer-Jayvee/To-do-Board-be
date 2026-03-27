<?php

namespace App\Services;
use App\Contract\AuthProvider;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthService implements AuthProvider
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * login
     *
     * @param  mixed $credentials
     * @return JsonResponse
     */
    public function login(array $credentials): JsonResponse
    {
        $username = $credentials['username'] ?? "";
        $password = $credentials['password'] ?? "";

        return response()->json([]);

    }
    /**
     * register
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {

        return response()->json([]);
    }
}

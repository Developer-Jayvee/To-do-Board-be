<?php

namespace App\Contract;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

interface AuthProvider
{
    public function login(array $credentials): JsonResponse;
    public function register(Request $request): JsonResponse;
}

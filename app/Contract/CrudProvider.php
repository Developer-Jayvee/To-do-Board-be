<?php

namespace App\Contract;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

interface CrudProvider
{
    public function index(): JsonResponse;
    public function store(Request $request);
    public function update(Request $request, int $id , bool $isCustomUpdate = false);
    public function show(int $id);
    public function destroy(int $id);
}

<?php

namespace App\Services;

use App\Contract\TicketProvider;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class TicketService implements TicketProvider
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    /**
     * createTicket
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function createTicket(Request $request): JsonResponse
    {
        throw new \Exception('Not implemented');
    }
}

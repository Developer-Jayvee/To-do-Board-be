<?php

namespace App\Contract;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

interface TicketProvider
{
    public function createTicket(Request $request): JsonResponse;
    public function ticketList(): JsonResponse;
}

<?php

namespace App\Services;

use App\Contract\TicketProvider;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\JsonResponse;

class TicketService extends Services implements TicketProvider
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
    public function ticketList(): JsonResponse
    {
        try {
            $data =  Cache::remember('ticketList', 60, function() {
                return Tickets::all();
            });
            
            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }
}

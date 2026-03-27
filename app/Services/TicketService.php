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
        try {
            $ticket = Tickets::create([
                'code' => 'T001',
                'title' => $request->title,
                'description' => $request->description,
                'label_id' => $request->label_id,
                'expiration_date' => date($request->expiration_date),
                'created_by' => $request->created_by,
            ]);

            if(!$ticket){
                throw new \Exception("Failed to create ticket \n Try again later");
            }
            return $this->successResponse([
                'ticket' => $ticket
            ],'Successfully Created Ticket');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
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

<?php

namespace App\Http\Controllers;

use App\Contract\TicketProvider;
use App\Http\Requests\StoreTicketsRequest;
use App\Http\Requests\UpdateProgressRequest;
use App\Http\Requests\UpdateTicketsRequest;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class TicketsController extends Controller
{
    protected $ticketService;
    public function __construct(TicketProvider $ticketService) {
        $this->ticketService = $ticketService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->ticketService->ticketList();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketsRequest $request)
    {
        return $this->ticketService->createTicket($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tickets $tickets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tickets $tickets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketsRequest $request, int $id)
    {
        return $this->ticketService->ticketUpdate($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tickets $tickets)
    {
        //
    }
    public function updateProgress(UpdateProgressRequest $request , int $id)
    {
       return $this->ticketService->updateProgress($request,$id);
    }
}

<?php

namespace App\Services;

use App\Contract\TicketProvider;
use App\Models\TicketHistory;
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
                'code' => 'T00' . Tickets::count() + 1,
                'title' => $request->title,
                'description' => $request->description,
                'label_id' => $request->label_id,
                'expiration_date' => date($request->expiration_date),
                'created_by' => $request->created_by ?? 1,
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
    /**
     * Ticket List
     *
     * @return JsonResponse
     */
    public function ticketList(): JsonResponse
    {
        try {
            // $data =  Cache::remember('ticketList', 60, function() {
                $data = Tickets::all();
            // });

            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }
    /**
     * Ticket Update
     *
     * @param  mixed $request
     * @param  mixed $id
     */
    public function ticketUpdate(Request $request, int $id)
    {
        $crudService = new CrudService(new Tickets);

        return $crudService->update($request,$id);
    }

    /**
     * updateProgress
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function updateProgress(Request $request, int $id)
    {
        try {
            $ticket = Tickets::find($id);
            if(!$ticket){
                throw new \Exception("Ticket does not exists.");
            }
            $input = $request->input();

            $from = $input["from"];
            $to = $input["to"];

            if($from === $to){
                return $this->successResponse("");
            }

            $sort = TicketHistory::where("ticket_id",$id)->count();
            $progress = TicketHistory::updateOrCreate(
                [ "ticket_id" => $id , "label_id" => $to , "prev_label_id" => $from , "sort" => $sort + 1 ],
                [ "ticket_id" => $id ]
            );

            return $this->successResponse($progress,"Successfully updated");
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }


    }
}

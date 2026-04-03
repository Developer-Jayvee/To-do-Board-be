<?php

namespace App\Services;

use App\Contract\TicketProvider;
use App\Enums\HistoryTypes;
use App\Models\Categories;
use App\Models\TicketHistory;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
                'code' => 'T00' . rand(10,100),
                'title' => $request->title,
                'description' => $request->description,
                'label_id' => $request->label_id,
                'category_id' => 26,
                'expiration_date' => date($request->expiration_date),
                'created_by' => $request->created_by ?? 1,
            ]);

            if(!$ticket){
                throw new \Exception("Failed to create ticket \n Try again later");
            }
            return $this->successResponse($ticket,'Successfully Created Ticket');
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
                $ticketPerCategory = Categories::with(["tickets"])->get();
            // });

            return $this->successResponse($ticketPerCategory);
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

            $previous = $input["previous"];
            $next = $input["next"];

            if($previous === $next){
                return $this->successResponse("");
            }


            $sort = TicketHistory::where("ticket_id",$id)->count();

            DB::beginTransaction();
                $ticket->updateOrFail([
                    "category_id" => $next
                ]);
                $progress = TicketHistory::create([
                    "ticket_id" => $id , "new_value" => $next , "previous_value" => $previous , "sort" => $sort + 1 , "type" => HistoryTypes::TICKET_PROGRESS
                ]);
            DB::commit();

            return $this->successResponse($progress,"Successfully updated");
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage());
        }


    }
}

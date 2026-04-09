<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class NotifController extends Controller
{

    public function checkNotif(Request $request): JsonResponse
    {
        try {
            $userId = $request->user()->id;
            $userTicket = Tickets::where("created_by",$userId)->where("hasNotif",false);
            $expiringSoon = $userTicket->clone()
                            ->whereDate('expiration_date', '>', now()->toDateString())
                            ->whereDate('expiration_date', '<=', now()->addDays(5)->toDateString())->count();

            $expiringToday = $userTicket->clone()->whereDate('expiration_date', '=', now()->toDateString())->count();

            if($expiringSoon === 0 && $expiringToday === 0) return $this->successResponse(null);
            $userTicket->each(fn($data) => $data->update(["hasNotif" => true]));

            return $this->successResponse([
                'today' => $expiringToday,
                'soon' => $expiringSoon
            ]);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}

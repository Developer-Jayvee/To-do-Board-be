<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketHistory extends Model
{
    protected $table = "ticket_histories";

    protected $fillable = [
        "ticket_id" , "new_value" , "previous_value" , "sort" , "type" , "is_closed"
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketHistory extends Model
{
    protected $table = "ticket_histories";

    protected $fillable = [
        "ticket_id" , "label_id" , "prev_label_id" , "sort" , "is_closed"
    ];
}

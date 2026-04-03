<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected $table = "tickets";

    protected $fillable = [
        'code' , 'title' , 'description' , 'expiration_date' ,'label_id' , 'category_id' ,'created_by'
    ];

}

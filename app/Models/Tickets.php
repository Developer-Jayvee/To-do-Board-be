<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tickets extends Model
{
    protected $table = "tickets";

    protected $fillable = [
        'code' , 'title' , 'description' , 'expiration_date' ,'label_id' , 'category_id' ,'created_by'
    ];

    public function label() : BelongsTo
    {
        return $this->belongsTo(Labels::class,"label_id");
    }

}

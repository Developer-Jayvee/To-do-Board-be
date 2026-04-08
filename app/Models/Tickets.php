<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tickets extends Model
{
    protected $table = "tickets";

    protected $fillable = [
        'code' , 'title' , 'description' , 'expiration_date' ,'label_id' , 'category_id' ,'created_by' , 'hasNotif' , 'hasExpired'
    ];

    public function label() : BelongsTo
    {
        return $this->belongsTo(Labels::class,"label_id");
    }
    public function category() : BelongsTo
    {
        return $this->belongsTo(Categories::class,"category_id");
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,"created_by");
    }

}

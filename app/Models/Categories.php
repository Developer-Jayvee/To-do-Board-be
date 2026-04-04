<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categories extends Model
{

    protected $table = "categories";

    protected $fillable = [
        'code' , 'title' , 'sort' , 'bgColor' ,'textColor', 'created_by'
    ];

    public function tickets() : HasMany
    {
        return $this->hasMany(Tickets::class,"category_id","id");
    }
}

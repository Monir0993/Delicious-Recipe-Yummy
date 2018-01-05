<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $fillable = [
        'user_id','name','r','image','no_of_ingredients','calories'
    ];
}

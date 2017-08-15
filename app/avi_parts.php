<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class avi_parts extends Model
{
    //
     protected $fillable = [
        'customer_id', 'back_number', 'part_number'
    ];
}

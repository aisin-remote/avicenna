<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class avi_opname extends Model
{
    //
     protected $fillable = [
        'part_number',
        'opname_date',
        'opname_quantity',
        'opname_user_id'

    ];
    protected $table='avi_opname';
}

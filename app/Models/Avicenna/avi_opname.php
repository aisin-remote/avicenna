<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_opname extends Model
{
    //
     protected $fillable = [
        'part_number',
        'opname_date',
        'opname_quantity',
        'location_code',
        'opname_user_id'

    ];
    protected $table='avi_opname';
}

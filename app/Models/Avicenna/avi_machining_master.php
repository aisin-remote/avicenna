<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_machining_master extends Model
{
    protected $fillable = [
        'line_no',
        'machine_name',
    ];

    protected $table='avi_machining_master';
}

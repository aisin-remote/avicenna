<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_machining extends Model
{
    protected $fillable = [
        'line_no',
        'machine_no',
        'tools_no',
        'std_life_time',
        'actual_life_time'
    ];

    protected $table='avi_machining';
}

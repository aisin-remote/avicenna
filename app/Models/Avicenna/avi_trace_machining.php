<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_trace_machining extends Model
{
    protected $table = 'avi_trace_machining';

    protected $fillable =[
    	'id',
    	'code',
    	'npk',
    	'date',
        'strainer_id',
        'line',
        'status'
    ];
}

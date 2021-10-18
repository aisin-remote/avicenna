<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_trace_assembling extends Model
{
    protected $table = 'avi_trace_assemblings';

    protected $fillable =[
    	'id',
    	'code',
    	'npk',
    	'line',
    	'status',
    	'date'
    ];
}

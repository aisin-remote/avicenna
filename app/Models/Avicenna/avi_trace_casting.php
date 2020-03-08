<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_trace_casting extends Model
{
    protected $table = 'avi_trace_casting';

    protected $fillable =[
    	'id',
    	'code',
    	'npk',
    	'line',
    	'status',
    	'date'
    ];
}

<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_trace_line_master extends Model
{
    protected $table = 'avi_trace_line_masters';

    protected $fillable =[
    	'id',
    	'line',
    	'ip'
    ];
}

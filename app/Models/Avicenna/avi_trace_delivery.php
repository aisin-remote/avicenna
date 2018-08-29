<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_trace_delivery extends Model
{
    protected $table = 'avi_trace_delivery';

    protected $fillable =[
    	'id',
    	'code',
    	'npk',
    	'date'
    ];
}

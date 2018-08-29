<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_trace_cycle extends Model
{
    protected $table = 'avi_trace_cycles';

    protected $fillable =[
    	'id',
    	'code',
    	'name',
    	'discription',
    	'plant',
    ];
}

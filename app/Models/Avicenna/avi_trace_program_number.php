<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_trace_program_number extends Model
{
    protected $table = 'avi_trace_program_number';

    protected $fillable =[
    	'id',
    	'code',
    	'product',
    	'customer'
    ];
}

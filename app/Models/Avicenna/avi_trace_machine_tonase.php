<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_trace_machine_tonase extends Model
{
     protected $table = 'avi_trace_machine_tonase';

    protected $fillable =[
    	'id',
    	'code',
    	'tonase'
    ];
}

<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_running_model extends Model
{
    protected $table = 'avi_running_model';

    protected $fillable =[
    	'line_number',
    	'back_number',
    	'part_number',
    	'running_qty',
    	'dandori_date',
    	'id_mutation',
    	'cumulative_qty'
    ];
}

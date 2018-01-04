<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_running_model extends Model
{
    protected $table = 'avi_running_model';

    protected $fillable =[
    	'ip_address',
    	'line_number',
    	'back_number',
    	'part_number',
    	'quantity',
    	'dandori_date',
    	'id_handled',
    	'buffer'
    ];
}

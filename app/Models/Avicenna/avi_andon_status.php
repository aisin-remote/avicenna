<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_andon_status extends Model
{	
	protected $table= 'avi_andon_status';
    protected $fillable =[
    	'line',
    	'status',
    	'status_before',
    	'pic_ldr',
    	'pic_spv',
    	'pic_mgr',
    	'pic_gm',
        'alcolla_last_id_downtime'
    ];
}

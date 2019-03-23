<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_andon_status extends Model
{
    protected $fillable =[   	
		'line',
    	'status',
    	'pic_ldr',
    	'pic_spv',
        'flag_spv',
    	'pic_mgr',
        'flag_mgr',
    	'pic_gm',
        'flag_gm',
    	'created_at',
    	'updated_at'
    ];

    protected $table = 'avi_andon_status';
}

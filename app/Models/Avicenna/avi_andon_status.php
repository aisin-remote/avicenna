<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_andon_status extends Model
{
    protected $fillable =[   	
		'line',
        'plant',
    	'status',
    	'pic_ldr',
    	'pic_spv',
        'cc_spv',
        'flag_spv',
        'pic_mgr',
        'cc_mgr',
        'flag_mgr',
    	'pic_gm',
        'flag_gm',
        'error_at',
    	'created_at',
    	'updated_at'
    ];

    protected $table = 'avi_andon_status';
}

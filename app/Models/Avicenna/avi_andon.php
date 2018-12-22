<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_andon extends Model
{
    protected $primaryKey = 'line';
    protected $fillable =[
    	'line',
    	'target',
    	'target_qty',
    	'actual_qty',
    	'balance',
    	'achive',
    	'dandori',
    	'loss_time_qa',
    	'loss_time_parts',
    	'loss_time_mc'
    ];
    
    public function running() {
        return $this->belongsTo('App\Models\Avicenna\avi_running_model', 'line', 'line_number');
    }
}

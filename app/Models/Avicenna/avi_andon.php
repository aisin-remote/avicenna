<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_andon extends Model
{
    protected $primaryKey = 'line';
    public $incrementing = false;
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
    	'loss_time_mc',
        'buffer_mutation',
        'buffer_alcolla'
    ];
    
    public function running() {
        return $this->belongsTo('App\Models\Avicenna\avi_running_model', 'line', 'line_number');
    }
    public function test() {
        $line = avi_andon_detail::select('*')
        ->join('avi_andons','avi_andon_details.word', '=', 'avi_andons.word');
        return $line ; 
    }
}

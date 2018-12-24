<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_andon_detail extends Model
{
    protected $primaryKey = 'back_no';
    protected $table = 'avi_andon_details';

    protected $fillable =[
    	'back_no',
    	'line',
    	'actual_qty_reg_address',
    	'value_reg',
    ];

}

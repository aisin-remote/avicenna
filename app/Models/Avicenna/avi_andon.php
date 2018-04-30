<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_andon extends Model
{
    protected $fillable =[
    	'line',
    	'reg_address',
    	'name_reg',
    	'value_reg'
    ];
}

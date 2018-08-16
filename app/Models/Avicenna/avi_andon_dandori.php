<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_andon_dandori extends Model
{
    protected $fillable =[
    	'ip_address',
    	'line',
    	'back_no',
    	'is_dandori'
    ];

    protected $table = 'avi_andon_dandori';
}

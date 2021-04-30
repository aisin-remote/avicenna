<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_andon_status_history extends Model
{
    protected $fillable =[
		'andon_id',
    	'status',
        'code',
        'error_at',
        'finish_at',
    	'created_at',
    	'updated_at'
    ];

    protected $table = 'avi_andon_status_histories';
}

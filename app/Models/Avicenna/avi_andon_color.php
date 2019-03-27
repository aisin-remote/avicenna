<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_andon_color extends Model
{
    protected $fillable =[
    	'description',
    	'created_at',
    	'updated_at'
    ];

    protected $table = 'avi_andon_color';
}

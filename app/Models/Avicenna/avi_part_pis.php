<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_part_pis extends Model
{
    // dev-1.0
    protected $table = 'avi_part_pis';

    // dev-1.0, get parent info (avi_parts info)
    public function hasPart() {
	    return $this->belongsTo('App\Models\Avicenna\avi_parts', 'part_number', 'part_number');
	}
}

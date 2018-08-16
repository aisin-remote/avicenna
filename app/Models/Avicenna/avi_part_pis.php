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

	// dev-1.0,
	protected $fillable = [
        'part_number',
        'part_number_ag',
        'part_number_kanban',
        'part_number_customer',
        'customer_code',
        'customer_code_ag',
        'part_kind',
        'part_dock',
        'back_number',
        'qty_kanban'

    ];
}

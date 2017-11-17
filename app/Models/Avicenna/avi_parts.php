<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

// dev-1.0, 20170926, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated

// dev-1.0, 20170926, Ferry, Declare disini jika butuh Class customizing sendiri
use App\Models\Avicenna\avi_part_pis;

class avi_parts extends Model
{
    public static function getQuantity($part_number){

    	return self::whereRaw('CONCAT(REPLACE(part_number_customer, "-", ""), "000") LIKE "%'.$part_number.'%"')->first();
    }

    public function hasPis ($part_kind, $part_dock) {
    	return avi_part_pis::where('part_number', $this->part_number)
    						->where('part_kind', $part_kind)
    						->where('part_dock', $part_dock)->first();
    }

    // dev-1.0,
	protected $fillable = [
        'part_number',
        'part_number_nostrip',
        'part_number_ag',
        'part_name',
        'product_grup',
        'product_line',
        'min_stock',
        'max_stock',
        'qty_kanban'

    ];
    protected $table='avi_parts';
}

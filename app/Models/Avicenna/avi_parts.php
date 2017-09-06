<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_parts extends Model
{
    //
     protected $fillable = [
        'customer_id', 'back_number', 'part_number'
    ];

    public static function getQuantity($part_number){

    	return self::where('part_number', $part_number)->first();
    
    }
}

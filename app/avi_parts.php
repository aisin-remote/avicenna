<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class avi_parts extends Model
{
    //
     protected $fillable = [
        'customer_id', 'supplier_id', 'back_number', 'part_number', 
        'part_number_customer', 'part_name', 'product_group', 'product_line', 
        'quantity_box', 'min_stock', 'max_stock'
    ];

    public static function getQuantity($part_number){

    	return self::where('part_number', $part_number)->first();
    
    }
}

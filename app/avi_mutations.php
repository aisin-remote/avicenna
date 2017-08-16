<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class avi_mutations extends Model
{
    protected $fillable = [
          'mutation_date','part_number','store_location','quantity','serial_no','loading_list',
          'delivery','customer','npk','flag_confirm','quantity_edited','npk_edited'
    ];

}

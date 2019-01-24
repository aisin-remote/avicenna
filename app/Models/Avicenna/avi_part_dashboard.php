<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_part_dashboard extends Model
{
    protected $fillable = [
        'part_number',
        'part_name',
        'line',
        'location'];
    protected $table='avi_part_dashboard';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class avi_part_dashboard extends Model
{
    protected $fillable = [
        'part_number',
        'part_name',
        'location'];
}

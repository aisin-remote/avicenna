<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_trace_kanban extends Model
{
    protected $fillable = [
        'id',
        'no_seri',
        'jenis_kanban',
        'code_part',
    ];
}

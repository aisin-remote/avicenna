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
        'code_part_2',
        'master_id',
    ];

    public function regis()
    {
        return $this->belongsTo('App\Models\Avicenna\avi_trace_kanban_master', 'master_id');
    }

}

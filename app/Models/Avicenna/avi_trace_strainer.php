<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_trace_strainer extends Model
{
    protected $guarded = ['updated_at'];

    /**
     * Relation strainer master
     */
    public function strainer()
    {
        return $this->belongsTo('App\Models\Avicenna\avi_trace_strainer_master', 'strainer_id');
    }
}

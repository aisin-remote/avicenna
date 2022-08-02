<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_trace_ng extends Model
{
    protected $guarded = ['updated_at'];

    public function ngdetail()
    {
        return $this->belongsTo('App\Models\Avicenna\avi_trace_ng_master', 'id_ng', 'id');
    }
}

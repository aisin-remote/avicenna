<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_trace_torimetron extends Model
{
    const STATUS_OK = '1';
    const STATUS_NG = '0';

    protected $guarded = ['updated_at'];
    protected $table = 'avi_trace_torimetron';
}

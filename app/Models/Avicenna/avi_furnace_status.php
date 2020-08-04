<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_furnace_status extends Model
{
    const STATUS_OK = '1';
    const STATUS_NG = '0';

    protected $guarded = ['updated_at'];
    protected $table = 'avi_furnace_status';

    public function user()
    {
        return $this->belongsTo('App\User', 'pic', 'npk');
    }
}

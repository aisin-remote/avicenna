<?php

namespace App\Models\Avicenna;

use Illuminate\Database\Eloquent\Model;

class avi_andon_target extends Model
{
    protected $table = 'avi_andon_target';

    protected $fillable =[];

    public function actual() {
        return $this->belongsTo('App\Models\Avicenna\avi_andon_actual', 'line', 'line');
    }

}

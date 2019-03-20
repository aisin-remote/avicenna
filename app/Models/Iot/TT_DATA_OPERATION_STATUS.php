<?php

namespace App\Models\Iot;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TT_DATA_OPERATION_STATUS extends Model
{
    protected $connection = 'sqlsrv';
    
    protected $table = 'TT_DATA_OPERATION_STATUS';   // dev-1.1.0: Ferry, merging test untuk koneksi ke MSSQL

    public $incrementing = false;

    protected $primaryKey = [
        'DTM_TIM_OPERATION_START',
        'CHR_COD_COMPANY',
        'CHR_COD_KJ',
        'CHR_COD_KOFU',
        'CHR_COD_LINE',
    ];

    protected $fillable =[
        'DTM_TIM_OPERATION_START',
        'CHR_COD_COMPANY',
        'CHR_COD_KJ',
        'CHR_COD_KOFU',
        'CHR_COD_LINE',
        'INT_KUB_OPERATION_STATUS',
        'DTM_TIM_OPERATION_END',
        'DTM_TIM_OPERATION_START_UTC',
        'DTM_TIM_SERVER_UTC',
        'INT_KEY_REFERENCE',
        'CHR_INF_SAKUSEI_USER',
        'CHR_NGP_SAKUSEI',
        'CHR_TIM_SAKUSEI',
        'CHR_INF_KOSIN_USER',
        'CHR_NGP_KOSIN',
        'CHR_TIM_KOSIN',
    ];

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('DTM_TIM_OPERATION_START', $this->getAttribute('DTM_TIM_OPERATION_START'))
            ->where('CHR_COD_COMPANY', $this->getAttribute('CHR_COD_COMPANY'))
            ->where('CHR_COD_KJ', $this->getAttribute('CHR_COD_KJ'))
            ->where('CHR_COD_KOFU', $this->getAttribute('CHR_COD_KOFU'))
            ->where('CHR_COD_LINE', $this->getAttribute('CHR_COD_LINE'));
        return $query;
    }

}

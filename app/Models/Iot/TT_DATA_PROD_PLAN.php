<?php

namespace App\Models\Iot;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TT_DATA_PROD_PLAN extends Model
{
    protected $connection = 'sqlsrv';
    
    protected $table = 'TT_DATA_PROD_PLAN';   // dev-1.1.0: Ferry, merging test untuk koneksi ke MSSQL

    public $incrementing = false;

    protected $primaryKey = [
        'DTM_DAY_PROD_PLAN',
        'CHR_COD_COMPANY',
        'CHR_COD_KJ',
        'CHR_COD_KOFU',
        'CHR_COD_LINE',
        'CHR_COD_HNMK',
    ];

    protected $fillable =[
        'DTM_DAY_PROD_PLAN',
        'CHR_COD_COMPANY',
        'CHR_COD_KJ',
        'CHR_COD_KOFU',
        'CHR_COD_LINE',
        'CHR_COD_HNMK',
        'DEC_SUR_PROD_PLAN',
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
            ->where('DTM_DAY_PROD_PLAN', $this->getAttribute('DTM_DAY_PROD_PLAN'))
            ->where('CHR_COD_COMPANY', $this->getAttribute('CHR_COD_COMPANY'))
            ->where('CHR_COD_KJ', $this->getAttribute('CHR_COD_KJ'))
            ->where('CHR_COD_KOFU', $this->getAttribute('CHR_COD_KOFU'))
            ->where('CHR_COD_LINE', $this->getAttribute('CHR_COD_LINE'))
            ->where('CHR_COD_HNMK', $this->getAttribute('CHR_COD_HNMK'));
        return $query;
    }

}

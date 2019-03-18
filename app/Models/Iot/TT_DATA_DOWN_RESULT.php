<?php

namespace App\Models\Iot;

use Illuminate\Database\Eloquent\Model;

class TT_DATA_DOWN_RESULT extends Model
{
    // protected $primaryKey=[
    //     'DTM_TIM_DOWN_OCCURRENCE',
    //     'CHR_COD_COMPANY',
    //     'CHR_COD_KJ',
    //     'CHR_COD_KOFU',
    //     'CHR_COD_LINE',
    //  ];
    protected $primaryKey ='DTM_TIM_DOWN_OCCURRENCE';
    protected $connection = 'sqlsrv';
    protected $table = 'TT_DATA_DOWN_RESULT';
    public $incrementing = false;
    protected $fillable =[
    	'DTM_TIM_DOWN_OCCURRENCE',
    	'CHR_COD_COMPANY',
    	'CHR_COD_KJ',
    	'CHR_COD_KOFU',
    	'CHR_COD_LINE',
    	'CHR_COD_STOP_P',
    	'INT_KUB_DOWN_STATUS',
    	'DTM_TIM_RESTORTION',
    	'DTM_TIM_DOWN_OCCURRENCE_UTC',
    	'DTM_TIM_SERVER_UTC',
        'INT_KEY_REFERENCE',
    	'CHR_INF_SAKUSEI_USER',
    	'CHR_NGP_SAKUSEI',
    	'CHR_TIM_SAKUSEI',
    	'CHR_INF_KOSIN_USER',
    	'CHR_NGP_KOSIN',
    	'CHR_TIM_KOSIN'
    ];
}

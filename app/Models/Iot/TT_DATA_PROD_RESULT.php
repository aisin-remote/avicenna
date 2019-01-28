<?php

namespace App\Models\Iot;

use Illuminate\Database\Eloquent\Model;

class TT_DATA_PROD_RESULT extends Model
{
    protected $connection = 'sqlsrv';
    protected $fillable =[
    	'DTM_TIM_PROD_RESULT',
    	'CHR_COD_COMPANY',
    	'CHR_COD_KJ',
    	'CHR_COD_KOFU',
    	'CHR_COD_LINE',
    	'CHR_COD_HNMK',
    	'DEC_SUR_RESULT',
    	'DEC_SUR_THROWOUT',
    	'DEC_TIM_CT',
    	'DTM_TIM_PROD_RESULT_UTC',
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

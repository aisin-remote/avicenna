<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Iot\TT_DATA_PROD_PLAN;

class IoTController extends Controller
{

	// BLADE ACTION
    function showProdPlan(Request $request) {

    	$path = null;
    	$rows = array();
        $posting = Carbon::now()->format('Y-m');
        $days = Carbon::now()->daysInMonth;

    	return view('avicenna.iot.prodplan', compact('rows', 'posting', 'days', 'path'));
    }

    function verifyProdPlan(Request $request) {

    	$path = null;
    	$rows = array();
    	$posting = $request->posting;
    	$days = Carbon::parse($request->posting.'-01')->daysInMonth;

    	if ($request->tipe == 'verify') {

	    	// dev-1.1.0, Ferry, 20190318. persiapkan file excel yang diupload
	        $path = Storage::putFile('fuploads', $request->file('fplan'));
	        $rows = Excel::load('storage/app/'.$path)->get();

    	}
    	elseif ($request->tipe == 'upload') {

    		$path = $request->myfile;
    		$rows = Excel::load('storage/app/'.$path)->get();

    		foreach ($rows as $row) {

	    		for ($i=1; $i <= $days; $i++) { 

	    			$this->insertDB($posting, $i, $row, $days);
	    		}
    		}
    	}

    	return view('avicenna.iot.prodplan', compact('rows', 'posting', 'days', 'path'));
    }

    // HELPER
    public static function countDaily($total, $days, $dayindex) {
    	$daily = floor($total / $days);
    	$sisa = $total % $days;

    	return ($daily + ($dayindex <= $sisa ? 1 : 0));
    }

    private function insertDB($yearmonth, $dayindex, $data, $days) {

    	$now = Carbon::now();
    	$qtydaily = $this->countDaily($data['total'], $days, $dayindex);
// dd($yearmonth.'-'.sprintf('%02d', $dayindex));
		$plan = TT_DATA_PROD_PLAN::firstOrNew([
				'DTM_DAY_PROD_PLAN' => ($yearmonth.'-'.sprintf('%02d', $dayindex)),
			    'CHR_COD_COMPANY' => 'J922',
			    'CHR_COD_KJ' => 'JE',
			    'CHR_COD_KOFU' => 'AS',
			    'CHR_COD_LINE' => $data['line'],
			    'CHR_COD_HNMK' => $data['partno']
		    ]);

		$plan->DEC_SUR_PROD_PLAN = $qtydaily;
		$plan->DTM_TIM_SERVER_UTC = Carbon::now('UTC')->format('Y-m-d H:i:s.0000000');
		$plan->INT_KEY_REFERENCE = 0;

		if (! $plan->exists) {

			$plan->CHR_INF_SAKUSEI_USER = \Auth::user()->npk;
			$plan->CHR_NGP_SAKUSEI = $now->format('Ymd');
			$plan->CHR_TIM_SAKUSEI = $now->format('His');
		}
		$plan->CHR_INF_KOSIN_USER = \Auth::user()->npk;
		$plan->CHR_NGP_KOSIN = $now->format('Ymd');
		$plan->CHR_TIM_KOSIN = $now->format('His');

		$plan->timestamps = false;
        $plan->save();
    }

}

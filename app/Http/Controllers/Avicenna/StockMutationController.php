<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated
use Yajra\Datatables\Datatables;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class customizing sendiri
use App\Models\Avicenna\avi_mutations;
use App\Models\Avicenna\avi_parts;
use App\Models\Avicenna\avi_opname;

class StockMutationController extends Controller
{
    //
    function getView(){
		return view('avicenna.stock.mutation');
	}

    function getViewFilter($part_number, $store_location, $date_from, $date_to){

    	// Prepare collections
    	$part_filter = avi_mutations::select('part_number', '0.00 AS stock_awal');

    	// Jika from = 20171004 dan to = 20171030
    	// STOCK AWAL = Hitung sto terakhir di avi opname hingga 20171004,
    	//				hitung mutasi sto+in-out di titik ketemu hingga 20171003

    	// STOCK IN = Mutasi IN dari 20171004 hingga 20171030

    	// STOCK OUT = Mutasi OUT dari 20171004 hingga 20171030

    	// STOCK AKHIR = STOCK AWAL + STOCK IN - STOCK OUT

		// Prepare collections
		$part_filters = avi_mutations::selectRaw('part_number, store_location, 0.00 AS stock_awal, 
													0.00 AS stock_in, 0.00 AS stock_out, 0.00 AS stock_akhir')
										->distinct()
										->get();

		foreach ($part_filters as $part_filter) {

			// STOCK AWAL =====================================================
			$last_opname = avi_opname::select('opname_date', 'opname_quantity')
										->whereDate('opname_date', '<', '20171004')
										->where('part_number', $part_filter->part_number)
										->orderBy('opname_date', 'desc')
										->first();

			$part_filter->stock_awal = $last_opname ? $last_opname->opname_quantity : 0;	// sto terdekat
			// hitung mutasi dari last_opname date hingga H-1
			$mutasi_awal = avi_mutations::whereDate('opname_date', '<', '20171004');
		}
		return $part_filters;


		return view('avicenna.stock.mutation');
	}

	public function getAjaxHeader()
	{

	    $mutation = avi_mutations::select();

	    return Datatables::of($mutation)
	        ->addColumn('details_url', function($mutation) {
	            return url('avicenna/stock/mutation/ajax/getDetail/' . $mutation->part_number);
	        })
	        ->addIndexColumn()
	        ->make(true);
	}

	public function getAjaxDetail($part_number)
	{
	    $part = avi_parts::select('part_number', 'part_name')
	    					->where('part_number', $part_number);

	    return Datatables::of($part)->make(true);
	}
}

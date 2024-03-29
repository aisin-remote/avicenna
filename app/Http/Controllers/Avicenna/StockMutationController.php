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
use App\Models\Avicenna\avi_andon_detail;
use App\Models\Avicenna\avi_part_dashboard;
use \Carbon; 
use DB;
class StockMutationController extends Controller
{
    //
    function getView(){
    	$lines = avi_part_dashboard::select('line')->groupby('line')->get();
    	// return $lines;
		return view('avicenna.stock.mutation', compact('lines'));
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

		$date = \Carbon\Carbon::now()->format('Y-m-d');
		$date2 = \Carbon\Carbon::yesterday()->format('Y-m-d');
	    $mutation = avi_mutations::select('avi_mutations.part_number','avi_mutations.store_location')
	    				->join('avi_part_dashboard', 'avi_mutations.part_number', '=', 'avi_part_dashboard.part_number')
	    				->groupby('avi_mutations.part_number')
	    				->groupby('avi_mutations.store_location');
	    return Datatables::of($mutation)
	        ->addColumn('details_url', function($mutation) {
	            return url('avicenna/stock/mutation/ajax/getDetailHead/'.$mutation->part_number);
	        })
	        ->addColumn('stock_initial', function($mutation) use($date) {

	        	$stock_initial = avi_mutations::select( DB::raw('Sum(quantity) as qty'))->where('part_number' , $mutation->part_number)->where('mutation_date', '<' , $date)->first();
	            if ( is_null($stock_initial['qty'])){
	        		return '0';
	        	}else{
	            	return  $stock_initial['qty'];
	        	}
	        })
	        ->addColumn('stock_in', function($mutation) use($date) {
	        	$stock_in = avi_mutations::select( DB::raw('Sum(if(quantity > 0,quantity,0)) as qty'))->where('part_number' , $mutation->part_number)->where('mutation_date', $date)->first();
	        	if ( is_null($stock_in['qty'])){
	        		return '0';
	        	}else{
	            	return  $stock_in['qty'];
	        	}
	        })
	        ->addColumn('stock_out', function($mutation) use($date) {
	        	$stock_out = avi_mutations::select( DB::raw('Sum(if(quantity < 0,quantity,0)) as qty'))->where('part_number' , $mutation->part_number)->where('mutation_date', $date)->first();
	            if ( is_null($stock_out['qty'])){
	        		return '0';
	        	}else{
	            	return  $stock_out['qty'];
	        	}
	        })
	        ->addColumn('end_stock', function($mutation) {
	        	$end_stock = avi_mutations::select( DB::raw('Sum(quantity) as qty'))->where('part_number' , $mutation->part_number)->first();
	            return  $end_stock['qty'] ;
	        })
	       
	        ->addIndexColumn()
	        ->make(true);
	}

	public function getAjaxDetailHead($part_number)
	{	

	    $date = \Carbon\Carbon::now()->format('Y-m-d');
	    $date2 = \Carbon\Carbon::yesterday()->format('Y-m-d');
	    $part = avi_mutations::select('back_number','mutation_date','part_number','part_name','desc', DB::raw('Sum(quantity) as total_qty'))
	    			->join('avi_mutation_types','code','mutation_code')
	    			->where('avi_mutations.part_number',$part_number)
	    			->where('mutation_date' , '<=' ,  $date )
	    			->where('mutation_date' , '>' ,  $date2 )
	    			->groupby('back_number','mutation_date', 'mutation_code', 'part_number','part_name','desc')
	    			->orderBy('mutation_date');
	    			
	    // return $part;
	    return Datatables::of($part)
	    ->make(true);
	}
	public function getAjaxFilter($start_date, $end_date, $line)
	{	
			if ($line == '' || $line == 'ALL') {
				$mutation = avi_mutations::select('avi_mutations.part_number','avi_mutations.store_location')
	    				->join('avi_part_dashboard', 'avi_mutations.part_number', '=', 'avi_part_dashboard.part_number')
	    				->groupby('avi_mutations.part_number')
	    				->groupby('avi_mutations.store_location');
			}else{
				$mutation = avi_mutations::select('avi_mutations.part_number','avi_mutations.store_location')
	    				->join('avi_part_dashboard', 'avi_mutations.part_number', '=', 'avi_part_dashboard.part_number')
	    				->where('avi_part_dashboard.line', $line)
	    				->groupby('avi_mutations.part_number')
	    				->groupby('avi_mutations.store_location');
			}

		    return Datatables::of($mutation)
		        ->addColumn('details_url', function($mutation) use($start_date , $end_date) {
		            return url('avicenna/stock/mutation/ajax/getDetailFilter/'.$mutation->part_number.'/'.$start_date.'/'.$end_date);
		        })
		        ->addColumn('stock_initial', function($mutation) use($start_date) {
		        	$stock_initial = avi_mutations::select( DB::raw('Sum(quantity) as qty'))->where('part_number' , $mutation->part_number)->where('mutation_date', '<' , $start_date)->first();
		            if ( is_null($stock_initial['qty'])){
		        		return '0';
		        	}else{
		            	return  $stock_initial['qty'];
		        	}
		        })
		        ->addColumn('stock_in', function($mutation) use($start_date , $end_date) {
		        	$stock_in = avi_mutations::select( DB::raw('Sum(if(quantity > 0,quantity,0)) as qty'))->where('part_number' , $mutation->part_number)->where('mutation_date', '>=' , $start_date)->where('mutation_date', '<=' , $end_date)->first();
		        	if ( is_null($stock_in['qty'])){
		        		return '0';
		        	}else{
		            	return  $stock_in['qty'];
		        	}
		        })
		        ->addColumn('stock_out', function($mutation) use($start_date , $end_date) {
		        	$stock_out = avi_mutations::select( DB::raw('Sum(if(quantity < 0,quantity,0)) as qty'))->where('part_number' , $mutation->part_number)->where('mutation_date', '>=' , $start_date)->where('mutation_date', '<=' , $end_date)->first();
		            if ( is_null($stock_out['qty'])){
		        		return '0';
		        	}else{
		            	return  $stock_out['qty'];
		        	}
		        })
		        ->addColumn('end_stock', function($mutation) use($end_date) {
		        	$end_stock = avi_mutations::select( DB::raw('Sum(quantity) as qty'))->where('part_number' , $mutation->part_number)->where('mutation_date', '<=' , $end_date)->first();
		            return  $end_stock['qty'] ;
		        })
		       
		        ->addIndexColumn()
		        ->make(true);
	}

	public function getAjaxDetailFilter($part_number, $start_date, $end_date)
	{	
	    $date = \Carbon\Carbon::now()->format('Y-m-d');
	    $part = avi_mutations::select('back_number','mutation_date','part_number','part_name','desc', DB::raw('Sum(quantity) as total_qty'))
	    			->join('avi_mutation_types','code','mutation_code')
	    			->where('avi_mutations.part_number',$part_number)
	    			->where('mutation_date' , '>=' ,  $start_date )
	    			->where('mutation_date' , '<=' ,  $end_date )
	    			->groupby('back_number','mutation_date','mutation_code','part_number','part_name','desc')
	    			->orderBy('mutation_date');
	    			
	    // return $start_date;
	    return Datatables::of($part)
	    ->make(true);
	}
}
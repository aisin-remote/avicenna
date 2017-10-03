<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated
use Yajra\Datatables\Datatables;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class customizing sendiri
use App\Models\Avicenna\avi_mutations;
use App\Models\Avicenna\avi_parts;

class StockMutationController extends Controller
{
    //
    function getView(){
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

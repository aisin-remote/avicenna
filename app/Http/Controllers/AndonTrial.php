<?php

namespace App\Http\Controllers;

use App\Models\Avicenna\avi_andon_color;
use App\Models\Avicenna\avi_andon_status;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

class AndonTrial extends Controller
{
    function index(){
		return view('andon.index');
	}
	public function index2()
    {
        $p = avi_andon_status::all();
        return view('andon.index2', compact('p'));
    }
	function getData(){
		$list = avi_andon_color::select('description');
		return Datatables::of($list)
		->make(true);
	}
	function getStatus(){
		$list = avi_andon_status::select('*');
		return Datatables::of($list)
		->make(true);
	}
}

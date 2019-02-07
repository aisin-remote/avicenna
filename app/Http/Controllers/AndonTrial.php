<?php

namespace App\Http\Controllers;

use App\Models\Avicenna\avi_andon_color;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

class AndonTrial extends Controller
{
    function index(){
		return view('andon.index');
	}
	function getData(){
		$list = avi_andon_color::select('description');
		return Datatables::of($list)
		->make(true);
	}
}

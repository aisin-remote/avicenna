<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;
use App\Models\Iot\TT_DATA_PROD_RESULT;

use App\Http\Requests;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role.menu', 'role.load']);
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('adminlte::home');
    }
    
    public function test()
    {
        $test = new TT_DATA_PROD_RESULT;
        $test->DTM_TIM_PROD_RESULT = '2019-01-11 06:05:00.0000000';
        $test->CHR_COD_COMPANY = 'TEST';
        $test->CHR_COD_KJ = 'TEST';
        $test->CHR_COD_KOFU = 'TEST';
        $test->CHR_COD_LINE = 'TEST';
        $test->CHR_COD_HNMK = 'TEST';
        $test->DEC_SUR_RESULT = 44;
        $test->DEC_SUR_THROWOUT = 44;
        $test->DEC_TIM_CT = 44;
        $test->DTM_TIM_PROD_RESULT_UTC = '2019-01-11 06:05:00.0000000';
        $test->DTM_TIM_SERVER_UTC = '2019-01-11 06:05:00.0000000';
        $test->INT_KEY_REFERENCE = '0';
        $test->CHR_INF_SAKUSEI_USER = '0';
        $test->CHR_NGP_SAKUSEI = '0';
        $test->CHR_TIM_SAKUSEI = '0';
        $test->CHR_INF_KOSIN_USER = NULL;
        $test->CHR_NGP_KOSIN = NULL;
        $test->CHR_TIM_KOSIN = NULL;

        $test->save();
    }
}
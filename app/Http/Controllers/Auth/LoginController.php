<?php

namespace App\Http\Controllers\Auth;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        attemptLogin as attemptLoginAtAuthenticatesUsers;
        logout as performLogout;        // dev-1.0, Ferry, 20170906, Override logout function to clear cache
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('adminlte::auth.login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Returns field name to use at login.
     *
     * @return string
     */
    public function username()
    {
        return config('auth.providers.users.field','email');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        if ($this->username() === 'email') return $this->attemptLoginAtAuthenticatesUsers($request);

        if ( ! $this->attemptLoginAtAuthenticatesUsers($request)) {
            return $this->attempLoginUsingUsernameAsAnEmail($request);
        } else {
            // nembak api
            // $client = new Client();
            // $response = $client->post(env('DOWA_BASE_URL').'/auth/login', [
            //     'body' => [
            //         'email' => env('DOWA_USER_MAIL'),
            //         'password' => env('DOWA_USER_PASSWORD')
            //     ],
            //     'headers' => [
            //         'Accept' => 'application/json'
            //     ]
            // ]);
            // $json = $response->json();
            // Cache::forever('dowa_token', $json['access_token']);
        }
        return false;
    }

    /**
     * Attempt to log the user into application using username as an email. (query ke field selain email)
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attempLoginUsingUsernameAsAnEmail(Request $request)
    {
        return $this->guard()->attempt(
            ['email' => $request->input('username'), 'password' => $request->input('password')],
            $request->has('remember'));
    }

    // dev-1.0, Ferry, 201709906, Jika melakukan logout clear cache juga
    public function logout(Request $request)
    {
        $this->performLogout($request);
        Cache::forget('avi_mutation_types');
        Cache::forget('avi_uoms');
        Cache::forget('avi_locations');
        return redirect('/login');
    }

}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/presence_in';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }

    protected function validateLogin(Request $request)
    {
        $ip = $this->getIp();

        $is_wfo = 0;

        // $min_lat = abs(-6.326000000000000);
        // $max_lat = abs(-6.327000000000000);

        // $min_long = 106.86800000000000;
        // $max_long = 106.86890000000000;

        // $lat = abs($request->latitude);
        // $long = $request->longitude;

        // Get the user details from database and check if user is exist and active.
        $user = User::where('email', $request->email)->first();
        if ($user && $user->status == 'INACTIVE') {
            throw ValidationException::withMessages([$this->username() => __('User has been desactivated.')]);
        }

        // if (!($lat >= $min_lat and $lat <= $max_lat and $long >= $min_long and $long <= $max_long)) {
        //     throw ValidationException::withMessages([$this->username() => __('Not in the office area.')]);
        // }

        if ($is_wfo == 1) {
            if (!str_contains($ip, '192.168.103')) {
                throw ValidationException::withMessages([$this->username() => __('Not use office network.')]);
            }
        }

        // Then, validate input.
        return $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
}

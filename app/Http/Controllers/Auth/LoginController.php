<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use DB;

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

    // check ip in array
    public function strposa($haystack, $needle, $offset = 0)
    {
        if (!is_array($needle)) $needle = array($needle);
        foreach ($needle as $query) {
            if (strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
        }
        return false;

        /* usage strposa
            $string = "192.168.40.255";
            $array  = array("192.168.10", "192.168.20", "192.168.30", "192.168.40");

            if (strposa($string, $array)) {
               echo 'true';
            } else {
                echo 'false';
            }
        */
    }

    protected function validateLogin(Request $request)
    {
        $ip = $this->getIp();
        // $ip_array = array("127.0.0.1","::1");
        $schedule = DB::table('verif_schedule_user')->where('email', $request->email)->first();

        $min_lat = abs(-6.326000000000000);
        $max_lat = abs(-6.327000000000000);

        $min_long = 106.86800000000000;
        $max_long = 106.86890000000000;

        $lat = abs($request->latitude);
        $long = $request->longitude;

        // Get the user details from database and check if user is exist and active.
        $user = User::where('email', $request->email)->first();
        if ($user && $user->status == 'INACTIVE') {
            throw ValidationException::withMessages([$this->username() => __('User has been desactivated.')]);
        }

        if (!($lat >= $min_lat and $lat <= $max_lat and $long >= $min_long and $long <= $max_long)) {
            throw ValidationException::withMessages([$this->username() => __('Not in the office area.')]);
        }

        if ($schedule == null) {
            throw ValidationException::withMessages([$this->username() => __('Jadwal anda belum di tentukan.')]);
        }

        // if ($schedule->id_schedule_type == 2 AND $schedule->is_open == 0) {
        //     if (!$this->strposa("$ip", $ip_array)) {
        //         throw ValidationException::withMessages([$this->username() => __('Not use office network.')]);
        //     }
        // }

        // Then, validate input.
        return $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
}

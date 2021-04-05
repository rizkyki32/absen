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

    protected function validateLogin(Request $request)
    {
        $min_lat = abs(-6.326000000000000);
        $max_lat = abs(-6.327000000000000);

        $min_long = 106.86800000000000;
        $max_long = 106.86890000000000;

        $lat = abs($request->latitude);
        $long = abs($request->longitude);
        
        // Get the user details from database and check if user is exist and active.
        $user = User::where('email', $request->email)->first();
        if ($user && $user->status == 'INACTIVE') {
            throw ValidationException::withMessages([$this->username() => __('User has been desactivated.')]);
        }

        if (!($lat >= $min_lat AND $lat <= $max_lat AND $long >= $min_long AND $long <= $max_long)) {
            throw ValidationException::withMessages([$this->username() => __('Bukan diarea kantor.')]);
        }

        // Then, validate input.
        return $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
}

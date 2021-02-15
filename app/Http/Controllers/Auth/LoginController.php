<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest')->except('logout');
    }

    /*
    |--------------------------------------------------------------------------
    | Manual Logout
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();  // remove all data from the session + regenerate

        $request->session()->regenerateToken();  // manually regenerate the session ID

        return response()->json(['messages' => ['Logged Out!']], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | Facebook Login
    |--------------------------------------------------------------------------
    */
    public function fbLogin(Request $request)
    {
        $redirect_url = Socialite::driver('facebook')
            ->scopes(['email'])  // https://developers.facebook.com/docs/permissions/reference
            ->redirect()->getTargetUrl();

        return response()->json(['target' => [$redirect_url]], 302);  // 前端 window.postMessage 來開
    }
}

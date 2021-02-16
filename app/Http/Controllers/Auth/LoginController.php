<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
    | Normal Login
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['messages' => ['輸入錯誤']], 400);
        }

        // 注意：密碼不要雜湊，框架在傳遞參數比對資料時會自動雜湊
        if (Auth::attempt($credentials)){
            $request->session()->regenerate();

            return response()->json(['messages' => ['登入成功']], 200);
        }

        return response()->json(['messages' => ['登入失敗']], 403);
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

    public function fbLoginCallback(Request $request)
    {
        if (is_null($request['code']) || is_null($request['state'])){
            return response()->json(['messages' => ['授權失敗']], 401);
        }

        Session::put('state', $request['state']);  // 不寫入 session 就要 stateless

        try{
            $fb_user = Socialite::driver('facebook')->user();
        } catch (\Exception $exception){
            Log::error($exception);
            return response()->json(['messages' => [strval($exception)]], 401);
        }

        // 確認使用者是否已經使用此方法註冊過
        if (User::where('facebook_id', $fb_user->getId())->exists()){  // 有
            // 登入
            Auth::guard('web')->login(User::where('facebook_id', $fb_user->getId())->first());
        } else if (User::where('email', $fb_user->getEmail())->exists()){  // 有相同 email 的使用者
            // 更新使用者資料
            DB::transaction(function () use ($fb_user){
                User::where('email', $fb_user->getEmail())->update([
                    'facebook_id' => $fb_user->getId()
                ]);
            });

            Auth::guard('web')->login(User::where('email', $fb_user->getEmail())->first());
        }else {  // 沒找到
            // 自動註冊
            DB::transaction(function () use ($fb_user){
                User::create([
                    'name' => $fb_user->getName(),
                    'email' => $fb_user->getEmail(),
                    'password' => Hash::make(uniqid('FB_')),
                    'facebook_id' => $fb_user->getId()
                ]);
            });

            Auth::guard('web')->login(User::where('email', $fb_user->getEmail())->where('facebook_id', $fb_user->getId())->first());
        }

        return response()->json(['messages' => ['登入成功！']], 200);
    }
}

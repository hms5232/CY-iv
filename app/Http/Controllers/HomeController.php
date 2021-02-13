<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        return view('home');
        $messages = array('HOME!!');
        return response()->json(compact('messages'), 200);
    }

    /**
     * Show the CSRF token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function csrf()
    {
        $messages = array(csrf_token());
        return response()->json(compact('messages'), 200);
    }
}

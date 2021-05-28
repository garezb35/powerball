<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $user;
    public $userLevel;
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('first');
    }

    public function first(){

        return view('first');
    }

    public function syncTImeWith(){
        echo strtotime("now");
    }

    public function register(){
        Redirect::to('login')->send();
    }

}

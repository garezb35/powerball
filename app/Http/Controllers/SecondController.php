<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Redirect;
class SecondController  extends Controller
{
    public $user;
    public $isLogged;
    public function  __construct(){
        $this->isLogged = false;
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $this->isLogged = true;
                $this->user = Auth::user();

            }
            if($this->isLogged && $this->user->second_use == 1 && !empty($this->user->second_password)){
                Redirect::to('veriPass')->send();
            }
            else{
                return $next($request);
            }
        });
    }
}

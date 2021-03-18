<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LottoController extends Controller
{
    public function index(Request $request){
        return view('lotto' , ["js"=>"","css"=>"pball-pick.css","pick_visible"=>"none"]);
    }
}

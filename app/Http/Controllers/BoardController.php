<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoardController extends Controller
{
    //
    public function view(Request $request){
        return view('board_view',["css"=>"board.css","js"=>""]);
    }
}

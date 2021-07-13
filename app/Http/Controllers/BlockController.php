<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlockController extends Controller
{
    function accessProtected(){
      return view('member/accessProtected', [
          "js" => "",
          "css" => ""
      ]);
    }
    function protectedip(){
      return view('member/protectedip', [
          "js" => "",
          "css" => ""
      ]);
    }
}

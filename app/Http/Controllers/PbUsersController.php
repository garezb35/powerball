<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CodeDetail;


class PbUsersController extends Controller
{
    //
    public function getUpdateUserLevel(){
       $user_model = new User;
       $users = $user_model::with(["getLevel","getLevel.code"])->find(25);
    }
}

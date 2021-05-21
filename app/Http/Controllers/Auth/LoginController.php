<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExpController;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LoginLog;
use App\Models\PbLog;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

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
    private $apiToken;
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



    public function authenticate(Request $request){
        // Retrive Input
        $credentials = $request->only('loginId', 'password');

        if (Auth::attempt($credentials)) {
            // if success login

            return redirect()->intended('/');

            //return redirect()->intended('/details');
        }
        // if failed login
        return redirect('logins');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'loginId';
    }

    public function process_login(Request $request)
    {
        $this->validateLogin($request);
        $request->validate([
            'loginId' => 'required',
            'password' => 'required'
        ]);
        $this->apiToken = Str::random(60);
        $desktop = 1;
        $agent = new \Jenssegers\Agent\Agent;
        if($agent->isMobile())
            $desktop = 0;
        $credentials = $request->except(['_token']);
        $user = User::where('loginId',$request->loginId)->first();

        if (auth()->attempt($credentials)) {
            if($user["user_type"] == 0){
                return $this->sendFailedLoginResponse($request);
            }
            if($user["isDeleted"] == 1){
                return $this->sendFailedLoginResponse($request);
            }

            $loginLog = new LoginLog;
            $dayLoginLog = LoginLog::whereDate("created_at",date("Y-m-d"))->where("userId",$user->userId)->orderBy("created_date","DESC")->count();
            if($dayLoginLog == 0 ){
                $new_exp = $user->exp + 10;
                User::where("userId",$user->userId)
                    ->update([
                        "exp"=>$new_exp
                    ]);

                $exp = new ExpController($user->userId,$new_exp);
                $exp->CheckNextLevel();

                PbLog::create([
                    "type"=>1,
                    "content"=>json_encode(array("exp"=>10,"msg"=>date("Y-m-d"). " 첫 로그인 경험치 지급")),
                    "userId"=>$user->userId,
                    "ip"=>$request->ip()
                ]);
            }
            LoginLog::create([
                "userId"=>$user->userId,
                "ip"=>$request->ip(),
                "machine"=>$desktop
            ]);
            User::where("userId",$user->userId)
                ->update([
                    "api_token"=>$this->apiToken
                ]);
            return redirect()->route('default');

        }else{
            return $this->sendFailedLoginResponse($request);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('default');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExpController;
use App\Models\PbIpBlocked;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LoginLog;
use App\Models\PbLog;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Stevebauman\Location\Facades\Location;

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
        // $credentials["user_type"] = "01";
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
        $user = User::with("blocked")->where('loginId',$request->loginId)->first();
        // $credentials["user_type"] = "01";
        if (auth()->attempt($credentials)) {

            $ip_blocked_list = PbIpBlocked::where("ip",$request->ip())->first();
            if(!empty($ip_blocked_list))
            {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return $this->sendFailedLoginResponse($request,"불법활동으로 인해 아이피가 차단되었습니다.",false);
            }

            if($user["isDeleted"] == 1){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return $this->sendFailedLoginResponse($request,"삭제된 회원입니다.",false);
            }

            if($user["user_type"] == 0){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return $this->sendFailedLoginResponse($request,"접속차단된 회원입니다",false);
            }

            if(!empty($user["accept_ip"])){
                if(!str_contains($user["accept_ip"],$request->ip())){
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return $this->sendFailedLoginResponse($request,"인증아이피 목록에 존재하지 않는 아이피입니다.",false);
                }
            }
            if($user["except_ip"] == 1){
                if(empty(Location::get($request->ip())) || (!empty(Location::get($request->ip())) && Location::get($request->ip())->countryCode != "KR")){
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return $this->sendFailedLoginResponse($request,"해외아이피접근차단.",false);
                }
            }

            if(!empty($user["second_password"]) && $user["second_active"] == 1){
                User::where("userId",$user["userId"])->update(["second_use"=>1]);
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
                    "api_token"=>$this->apiToken,
                    "ip"=>$request->ip()
                ]);
            return redirect()->route('default');

        }else{
            return $this->sendFailedLoginResponse($request);
        }
    }

    public function logout(Request $request)
    {
        if(Auth::check()){
          $user = Auth::user();
          $user->api_token = "";
          $user->save();
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('default');
    }
    protected function sendFailedLoginResponse(Request $request ,$msg = "아이디 또는 비밀번호가 일치하지 않습니다.",$auth = true)
    {

        if($auth){
            if (!User::where('loginId', $request->email)->first()) {
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors([
                        "failed" => $msg,
                    ]);
            }

            if (!User::where('loginId', $request->email)->where('password', bcrypt($request->password))->first()) {
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors([
                        'failed' => $msg,
                    ]);
            }
        }

        else{
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    'failed' => $msg,
                ]);
        }
    }
}

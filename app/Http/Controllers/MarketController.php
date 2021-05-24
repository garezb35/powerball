<?php

namespace App\Http\Controllers;

use App\Models\PbItemUse;
use App\Models\PbLog;
use App\Models\PbMarket;
use App\Models\PbPurItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use const http\Client\Curl\AUTH_ANY;

class MarketController extends Controller
{
    //
    public function view(Request $request){
        if(!Auth::check())
        {
            echo "<script>alert('로그인 후 이용가능합니다.');window.history.go(-1);</script>";
            return;
        }
        $item = array();
        $type = "";
        $item_type = $request->type;
        if($item_type == "item")
            $type = 1;
        if($item_type == "use")
            $type = 2;
        $record = PbMarket::where("state",1)->where("type","!=",3);
        if(!empty($type))
            $record = $record->where("type",$type);
        $record = $record->orderBy("order","ASC")->get()->toArray();
        if(!empty($record))
            foreach($record as $value)
            {
                if(!isset($item[$value["price_type"]]))
                    $item[$value["price_type"]] = array();
                array_push($item[$value["price_type"]],$value);
            }
        return view('market',["js"=>"market.js","css"=>"market.css","pick_visible"=>"none","item"=>$item]);
    }

    public function buyItem(Request $request){
        $code = $request->code;
        $count = $request->count;
        $insert_id = 0;
        $insert_count = 0;
        $insert_price = array();
        $user = Auth::user();
        $item = PbMarket::where("code",$code)->where("state",1)->first();

        if(empty($item))
        {
            echo json_encode(array("status"=>0,"code"=>18,"message"=>"해당 아이탬이 존재하지 않습니다."));
            return;
        }

        if($count <= 0){
            echo json_encode(array("status"=>0,"code"=>19,"message"=>"0보다 작을수 없습니다."));
            return;
        }

        if($count > $item["limit"]){
            echo json_encode(array("status"=>0,"code"=>20,"message"=>"해당 상품의 1회 최대구매 수량을 초과하였습니다."));
            return;
        }

        $pur_item = PbPurItem::where("userId",$user->userId)->where("market_id",$code)->first();
        if(!empty($pur_item))
        {
            $insert_count = $pur_item["count"];
        }
        $price = $item['price'] * $count;
        $new_exp = $user->exp + $count * $item["bonus"];
        if(!empty($item["bonus"])){
            PbLog::create([
                "type"=>1,
                "content"=>json_encode(array("exp"=>$item["bonus"],"msg"=>"[{$item["name"]}] 구매 보너스 경험치 지급")),
                "userId"=>$user->userId,
                "ip"=>$request->ip()
            ]);
        }
        if($item["price_type"] ==1){
            if($price > $user->coin){
                echo json_encode(array("status"=>0,"code"=>0,"message"=>"코인이 부족합니다.\n코인 충전 페이지로 이동하시겠습니까?"));
                return;
            }
            $insert_price = ["coin"=>$user->coin - $price , "exp"=>$new_exp];
        }
        if($item["price_type"] ==2){
            if($price > $user->bread){
                echo json_encode(array("status"=>0,"code"=>1,"message"=>"도토리가 부족합니다.\n도토리 획득후 이용하시기 바랍니다."));
                return;
            }
            $insert_price = ["bread"=>$user->bread - $price , "exp"=>$new_exp];
        }


        foreach($insert_price  as $key => $value){
            $user->$key = $value;
        }
        if(str_contains($code,"BULLET_"))
            $user->bullet = $count * $item["detail_count"] + $user->bullet;
        $user->save();
        $exp = new ExpController($user->userId,$new_exp);
        $exp->CheckNextLevel();
        if(!str_contains($code,"BULLET_"))
            PbPurItem::updateOrCreate([
                "userId"=>$user->userId,
                "market_id"=>$code
            ],
                [
                    "count"=>$count * $item["detail_count"] + $insert_count
                ]);
            PbLog::create([
                "type"=>2,
                "content"=>json_encode(array("class"=>"purchase","use"=>"구매","name"=>$item["name"],"count"=>$count,"price"=>$price)),
                "userId"=>$user->userId,
                "ip"=>$request->ip()
            ]);

        echo json_encode(array("status"=>1));
    }

    public function useItem(Request $request){
        $code = $request->code;
        $count = $request->count;
        $user = Auth::user();
        $terms_type = 1;
        $terms1 = $terms2 = "";
        if($count <=0 || $count > 1){
            echo json_encode(array("status"=>0,"code"=>20));
            return;
        }
        $pur_item = new PbPurItem();
        $pur_item = $pur_item->with("items")->where("pb_pur_item.userId",$user->userId)->where("pb_pur_item.market_id",$code)->where("pb_pur_item.count",">",0)->where("pb_pur_item.active",1)->first();
        if(empty($pur_item) || empty($pur_item->items)){
            echo json_encode(array("status"=>0,"code"=>19));
            return;
        }
        if(empty($pur_item["count"]))
        {
            echo json_encode(array("status"=>0,"code"=>16));
            return;
        }

        if(!empty($pur_item->items->period)){
            $pbitem = new PbItemUse();
            $search_code = $code;
            if(str_contains($code,"HIGH_LEVEL_UP")){
                $search_code = "%HIGH_LEVEL_UP%";
                $used_item = $pbitem->where("market_id","LIKE",$search_code);
            }
            else
                $used_item = $pbitem->where("market_id",$search_code);

            $used_item = $used_item->where("userId",$user->userId)
                ->where("terms_type",2)
                ->where("terms2",">=",date("Y-m-d H:i:s"))
                ->where("terms1","<=",date("Y-m-d H:i:s"))->first();
            if(!empty($used_item))
            {
                echo json_encode(array("status"=>0,"code"=>18));
                return;
            }
            $terms1 = date("Y-m-d H:i:s");
            $terms2 = date("Y-m-d H:i:s", strtotime($pur_item->items->period, strtotime($terms1)));
            $terms_type = 2;
            PbItemUse::updateorCreate([
                "userId"=>$user->userId,
                "market_id"=>$code
            ],[
                "terms2"=>$terms2,
                "terms1"=>$terms1,
                "terms_type"=>$terms_type
            ]);

            PbPurItem::where("id",$pur_item["id"])->update(["count"=>$pur_item["count"]-1]);
            PbLog::create([
                "type"=>2,
                "content"=>json_encode(array("class"=>"use","use"=>"사용","name"=>$pur_item->items->name,"count"=>1,"price"=>$pur_item->items->price)),
                "userId"=>$user->userId,
                "ip"=>$request->ip()
            ]);
            echo json_encode(array("status"=>1,"code"=>-100));
            return;
        }
        else if($code == "SUPER_NICKNAME_RIGHT"){
            PbPurItem::where("id",$pur_item["id"])->update(["count"=>$pur_item["count"]-1]);
            $user->nickname = $user->old_nickname;
            $user->save();
            echo json_encode(array("status"=>1,"code"=>-3));
        }
        else if($code =="RANDOM_EXP_BOX_20"){
            PbPurItem::where("id",$pur_item["id"])->update(["count"=>$pur_item["count"]-1]);
            $exps = [10,10,40,30,20,10,10,30,60,30,10,10,10,10,60,200,10,10,80,10];
            if(!empty($exps))
            {
                $index = rand(0,sizeof($exps));
                $rand_exp = rand(10,$exps[$index]);
            }
            else
                $rand_exp = 10;
            if($rand_exp > 0)
            {
                $user->exp +=$rand_exp;
                $user->save();
            }
            echo json_encode(array("status"=>1,"code"=>-2));
        }
        else if($code == "PICK_INIT"){
            echo json_encode(array("status"=>1,"code"=>-1));
        }
        PbLog::create([
            "type"=>2,
            "content"=>json_encode(array("class"=>"use","use"=>"사용","name"=>$pur_item->items->name,"count"=>1,"price"=>$pur_item->items->price)),
            "userId"=>$user->userId,
            "ip"=>$request->ip()
        ]);
    }
}

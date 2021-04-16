<li>
    @if($list["hot_icon"]==1)<div class="edge"><img src="https://simg.powerballgame.co.kr/images/edge_hot.png" width="55" height="55"></div>@endif
    @if($list["hot_icon"]==2)<div class="edge"><img src="https://simg.powerballgame.co.kr/images/edge_new.png" width="55" height="55"></div>@endif
    <img src="{{$list["image"]}}" width="115" height="100">
    <div class="name">{{$list["name"]}}</div>
    @if(!empty($list["bonus"]))
        <div class="bonus"><span class="tit">보너스</span> <span class="exp">{{$list["bonus"]}}EXP</span></div>
    @endif
    <div class="desc">{{$list["description"]}}</div>

    <div class="priceBox">
        <div class="price">{{$head}} {{number_format($list["price"])}} {{$coin}}</div>
        <div class="amountSet">
            <input type="text" name="{{$list["code"]}}" maxlength="2" value="1개" rel="1" limit="{{$list["limit"]}}" style="ime-mode:disabled;" onkeydown="return isNumber(event);" onblur="countChk(this);">
            <span class="up"></span>
            <span class="down"></span>
        </div>
        <div class="btn-g">
            <a href="#" class="btn_buy btn btn-sm" itemcode="{{$list["code"]}}" title="{{$list["name"]}}">구매</a>
            @if(!empty($list["gift_used"]))
            <a href="#" class="btn_gift btn btn-outline-secondary btn-sm" itemcode="{{$list["code"]}}" title="{{$list["name"]}}" >선물</a>
            @endif
        </div>
    </div>
</li>

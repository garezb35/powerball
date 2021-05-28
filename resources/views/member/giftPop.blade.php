@extends('includes.empty_header')
@section("content")
    <script>
        var userNick = '{{$nickname}}';
        var itemCode = '{{$itemCode}}';
        var api_token = '{{$api_token}}';
    </script>
    <div class="giftPopBox">
        <div class="title">아이템 선물하기</div>
        <div class="content">
            <div class="tit">선물할 아이템</div>
            <ul class="itemList">
                <li>

                    <img src="{{$item["image"]}}" width="115" height="115">
                    <div class="name">{{$item["name"]}}</div>
                    <div class="desc">{{$item["description"]}}</div>
                    <div class="price">{{number_format($item["price"])}} @if($item["price_type"] ==1 ){{"코인"}}@else{{"도토리"}}@endif</div>
                </li>
            </ul>

            <div class="inputBox">
                <table>
                    <tbody><tr>
                        <th>받는 회원 닉네임</th>
                        <td class="highlight"><input type="text" name="targetNick" id="targetNick"></td>
                    </tr>
                    <tr>
                        <th>아이템 수량</th>
                        <td>
                            <div class="amountSet">
                                <input type="text" name="itemCnt" id="itemCnt" maxlength="2" value="1개" rel="1" limit="50" style="ime-mode:disabled;" onkeydown="return isNumber(event);" onblur="countChk(this);">
                                <span class="up"></span>
                                <span class="down"></span>
                            </div>
                        </td>
                    </tr>
                    </tbody></table>
            </div>
        </div>
        <div class="btn">
            <a href="#" onclick="giftItem();return false;" class="gift">선물하기</a>
            <a href="#" onclick="self.close();" class="cancel">취소</a>
        </div>
    </div>
@endsection

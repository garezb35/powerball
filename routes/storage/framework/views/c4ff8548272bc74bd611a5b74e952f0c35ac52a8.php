<?php $__env->startSection("content"); ?>
<div class="marketBox">
    <input type="hidden" id="api_token" value="<?php echo e(AUth::user()->api_token); ?>">
    <div class="title">
        <ul>
            <li><a href="<?php echo e(route("market")); ?>" target="mainFrame" <?php if(empty(Request::get("type"))): ?> class="on" <?php endif; ?>>전체</a></li>
            <li><a href="<?php echo e(route("market")); ?>?type=item" target="mainFrame" <?php if(Request::get("type") =="item"): ?> class="on" <?php endif; ?>>아이템</a></li>
            <li><a href="<?php echo e(route("market")); ?>?type=use" target="mainFrame" <?php if(Request::get("type") =="use"): ?> class="on" <?php endif; ?>>이용권</a></li>

            <li class="right"><a href="/member?type=charge" target="mainFrame">코인충전</a></li>
        </ul>
    </div>
    <div class="content">
        <div id="itemTooltipBox" style="position:absolute;z-index:99;padding:10px;left:104px;border:1px solid #000;background-color:#127CCB;width:600px;height:600px;color:#fff;display:none;">
            <div style="position:absolute;top:0;right:0;display:inline-block;border:1px solid #454545;width:36px;height:36px;line-height:36px;text-align:center;background-color:#fff;color:#000;cursor:pointer;z-index:99;" id="close_tooltip"><img src="https://simg.powerballgame.co.kr/images/btn_tooltipClose.png" width="36" height="36"></div>
            <div id="tooltip"></div>
        </div>
        <form name="chargeForm" method="post" action="<?php echo e(route("setCharge")); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="chargeType" id="chargeType" value="deposit">
            <input type="hidden" name="chargeCoin" id="chargeCoin">
            <input type="hidden" name="chargePrice" id="chargePrice">

            <div class="chargeBox">
                <h2><img src="https://simg.powerballgame.co.kr/images/tit_coin.png"></h2>
                <div class="text">
                    파워볼게임에서 서비스하는 유료 컨텐츠를 이용하기 위해서 회원이 구매하는 인터넷상의 화폐입니다.<br>
                    파워볼게임에서는 현재 결제수단으로 무통장입금만을 제공하고 있습니다.<br>
                    추후 다양한 결제수단이 추가될 예정입니다.<br>
                    코인은 마켓에서 아이템을 구매하는데 사용됩니다.
                </div>

                <h2 class="subtitle">상품선택</h2>
                <ul class="coinList">
                    <li>
                        <img src="https://simg.powerballgame.co.kr/images/coin_s.png" class="grayscale">
                        <div class="price" rel="10000">10,000</div>
                    </li>
                    <li>
                        <img src="https://simg.powerballgame.co.kr/images/coin_s.png" class="grayscale">
                        <div class="price" rel="20000">20,000</div>
                    </li>
                    <li>
                        <img src="https://simg.powerballgame.co.kr/images/coin_s.png" class="grayscale">
                        <div class="price" rel="30000">30,000</div>
                    </li>
                    <li>
                        <img src="https://simg.powerballgame.co.kr/images/coin_s.png" class="grayscale">
                        <div class="price" rel="50000">50,000</div>
                    </li>
                    <li>
                        <img src="https://simg.powerballgame.co.kr/images/coin_l.png" class="grayscale">
                        <div class="price" rel="100000">100,000</div>
                    </li>
                    <li>
                        <img src="https://simg.powerballgame.co.kr/images/coin_l.png" class="grayscale">
                        <div class="price" rel="200000">200,000</div>
                    </li>
                    <li>
                        <img src="https://simg.powerballgame.co.kr/images/coin_l.png" class="grayscale">
                        <div class="price" rel="300000">300,000</div>
                    </li>
                    <li>
                        <img src="https://simg.powerballgame.co.kr/images/coin_l.png" class="grayscale">
                        <div class="price" rel="500000">500,000</div>
                    </li>
                    <ul>

                        <h2 class="subtitle">직접입력</h2>
                        <div class="coinInput">
                            <img src="https://simg.powerballgame.co.kr/images/coin_m.png" class="grayscale">
                            <input type="text" class="input" name="chargeCoinInput" id="chargeCoinInput" placeholder="직접입력" onkeypress="onlyNumber();" maxlength="7">
                            <span class="select">
					<a href="#" rel="10000" class="plusCoin">+1만</a>
					<a href="#" rel="50000" class="plusCoin">+5만</a>
					<a href="#" rel="100000" class="plusCoin">+10만</a>
					<a href="#" rel="500000" class="plusCoin">+50만</a>
					<a href="#" rel="0" class="plusCoin">초기화</a>
				</span>
                            <div class="txt"><span class="dot">※</span> 충전하고자 하는 코인의 충전금액을 만원 단위로 입력 가능합니다.</div>
                        </div>

                        <h2 class="subtitle">결제정보</h2>
                        <div class="depositBox">
                            <table>
                                <tbody>
                                <tr>
                                    <th>결제금액</th>
                                    <td><span class="price" id="price">0</span> 원</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td style="padding:10px 0 10px 0;line-height:20px;">상품금액 : <strong id="price_charge">0</strong> 원<br>부가세 : <strong id="price_vat">0</strong> 원</td>
                                </tr>
                                <tr>
                                    <th>계좌번호</th>
                                    <td>기업은행 <strong class="red" style="font-family:tahoma;">483-062658-04-025</strong> 주식회사엠커넥트</td>
                                </tr>
                                <tr>
                                    <th>입금자 이름</th>
                                    <td><input type="text" name="accountName" style="width:60px;"></td>
                                </tr>
                                <tr>
                                    <th>입금정보 받을 휴대폰번호</th>
                                    <td style="position:relative;"><input type="text" name="mobileNum" id="mobileNum" style="ime-mode:disabled;" onkeypress="onlyNumber();"> <span class="small">'-' 없이 숫자만 입력하세요.</span></td>
                                </tr>
                                <tr>
                                    <th>문자 발송</th>
                                    <td class="msg" style="position:relative;"><span style="position:absolute;top:10px;"><input type="checkbox" class="check" name="smsYN" value="Y" id="smsYN" checked=""></span> <label for="smsYN" style="margin-left:25px;">체크시 입금하실 계좌 정보를 문자로 보내드립니다.</label></td>
                                </tr>
                                <tr>
                                    <th class="none"></th>
                                    <td class="none msg"><strong class="red">신청하기 버튼을 눌러주셔야 입금신청이 완료됩니다.</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="chargeBtn">
                            <a href="#" onclick="charge();return false;" class="btn">코인충전 신청하기</a>
                        </div>
                    </ul>
                </ul>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/powerball-charge.blade.php ENDPATH**/ ?>
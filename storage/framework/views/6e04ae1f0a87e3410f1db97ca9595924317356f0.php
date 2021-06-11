

<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('member/member-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
    <div class="content">

        <style>
            .privacyTable {width:100%;margin:5px 0;}
            .privacyTable th {width:150px;background-color:#f7f7f7;border:1px solid #ddd;padding:5px 12px;text-align:left;}
            .privacyTable td {background-color:#fff;border:1px solid #ddd;padding:5px 12px;line-height:20px;}
        </style>

        <div style="margin-bottom:5px;"><span class="b">■ 총알 환전</span>&nbsp;&nbsp;<span style="font-size:11px;">총알 보유현황 확인 및 총알 환전 신청을 하실 수 있습니다.</span></div>
        <div class="memberInfoBox">

            <table border="0" cellspacing="0" cellpadding="0" class="table">
                <colgroup>
                    <col>
                </colgroup>

                <tbody><tr>
                    <td class="tit">이미 환전한 총알 개수 : <span class="highlight">0</span>개</td>
                </tr>
                <tr>
                    <td class="tit">환전 가능한 총알이 <span class="highlight">100개 이상</span>이어야 환전 신청이 가능하며 <span class="highlight">총알 1개당 현금 70원</span>으로 환전됩니다.</td>
                </tr>
                <tr>
                    <td class="tit">환전 신청한 총알의 환전액수에 관계없이 <span class="highlight">소득세 3%, 주민세 0.3%</span>가 적용됩니다.</td>
                </tr>
                <tr>
                    <td class="tit highlight">총알을 현금으로 환전 받으시면 환전액수에 관계없이 종합소득세 신고의무가 발생합니다.<br>(매년 5월은 종합소득세 신고기간 입니다.)</td>
                </tr>
                <tr>
                    <td class="tit">21시 이전 신청건은 당일 처리 되며. 21시 이후 신청건은 익일 오전 10시 이후에 처리됩니다.<br><span class="highlight">총알 환전 시각 : 10시, 21시 (일괄처리)</span></td>
                </tr>
                <tr>
                    <td class="tit">※ 불법적인 용도, 법적인 문제가 발생하는 경우, 비정상적인 경우, 본 사이트 약관에 위배되는 경우에는 <span class="highlight">환전 신청 승인이 거절</span>됩니다.</td>
                </tr>
                </tbody></table>
        </div>
        <form name="exchangeForm" method="post" action="<?php echo e(route("request-exchange")); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="rtnUrl" value="/member?type=exchange">
            <input type="hidden" name="oknameYN" value="N">
            <div class="memberInfoBox" style="margin-top:5px;">
                <table border="0" cellspacing="0" cellpadding="0" class="table">
                    <colgroup>
                        <col width="130px">
                        <col width="190px">
                        <col>
                    </colgroup>

                    <tbody><tr>
                        <td class="tit">환전가능 총알 개수 <span class="red"></span></td>
                        <td colspan="2" class="pdL10"><span class="highlight b">0</span>개</td>
                    </tr>
                    <tr>
                        <td class="tit">환전할 총알 개수 <span class="red"></span></td>
                        <td colspan="2"><input type="text" name="bullet" class="input" style="width:50px;ime-mode:disabled;"  onkeyup="calPrice();" required min="100"> 개</td>
                    </tr>
                    <tr>
                        <td class="tit">환전 실수령액</td>
                        <td colspan="2" class="pdL10"><span id="price" class="highlight b"></span>원 <span id="priceDesc"></span></td>
                    </tr>
                    <tr>
                        <td class="tit">아이디 <span class="red"></span></td>
                        <td colspan="2" class="pdL10">pejjwh16</td>
                    </tr>
                    <tr>
                        <td class="tit">비밀번호 <span class="red"></span></td>
                        <td colspan="2"><input type="password" name="passwd" class="input" required></td>
                    </tr>
                    <tr>
                        <td class="tit">이름 <span class="red"></span></td>
                        <td colspan="2" class="pdL10">
                            <input type="text" name="username" value="이장훈" style="border:none;" readonly="">
                        </td>
                    </tr>
                    <tr>
                        <td class="tit">실명인증 <span class="red"></span></td>
                        <td colspan="2" class="pdL10"><a href="#" class="btn2" style="width:350px;display:inline-block;" onclick="oknamePop();return false;">실명인증하기 [인증 후 5분 내 환전 미신청시 재인증 필요]</a></td>
                    </tr>
                    <tr>
                        <td class="tit">주민등록번호 <span class="red"></span></td>
                        <td><input type="text" name="jumincode" class="input" style="ime-mode:disabled;" onkeypress="onlyNumber();" maxlength="13" required></td>
                        <td class="guideMsg">- 없이 숫자만 입력해주세요.</td>
                    </tr>
                    <tr>
                        <td class="tit">휴대폰번호 <span class="red"></span></td>
                        <td><input type="text" name="mobile" class="input" style="ime-mode:disabled;" onkeypress="onlyNumber();" required></td>
                        <td class="guideMsg">- 없이 숫자만 입력해주세요.</td>
                    </tr>
                    <tr>
                        <td class="tit">은행 <span class="red"></span></td>
                        <td colspan="2">
                            <select name="accountCode" class="input" required>
                                <option value="">선택</option>
                                <?php if(!empty($bank)): ?>
                                <?php $__currentLoopData = $bank; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($b["id"]); ?>"><?php echo e($b["name"]); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="tit">예금주 <span class="red"></span></td>
                        <td colspan="2"><input type="text" name="accountName" class="input" required></td>
                    </tr>
                    <tr>
                        <td class="tit">계좌번호 <span class="red"></span></td>
                        <td><input type="text" name="accountNo" class="input" style="ime-mode:disabled;" onkeypress="onlyNumber();" required></td>
                        <td class="guideMsg">- 없이 숫자만 입력해주세요. (개인명의 계좌로만 환전 가능합니다. 사업자계좌 환전 불가)</td>
                    </tr>


                    <tr>
                        <td class="tit">신분증 사본 <span class="red"></span></td>
                        <td><input type="file" name="idcard" style="margin-left:10px;width:180px;"></td>
                        <td class="guideMsg">이미지 파일 첨부(JPG,GIF,BMP,PNG), 최대 업로드 가능 용량 2MB</td>
                    </tr>

                    <tr>
                        <td class="tit">통장 사본 <span class="red"></span></td>
                        <td><input type="file" name="bankbook" style="margin-left:10px;width:180px;"></td>
                        <td class="guideMsg">이미지 파일 첨부(JPG,GIF,BMP,PNG), 최대 업로드 가능 용량 2MB</td>
                    </tr>
                    </tbody>
                </table>

                <div style="border:1px solid #ddd;margin-top:5px;padding:10px;background-color:#EFEFEF;">
                    <div style="font-weight:bold;">제 1조 회원정보의 보호 및 이용</div>
                    ① 회사는 총알 환전의 목적으로 회원의 동의 하에 관계 법령에서 정하는 바에 따라 개인정보를 수집할 수 있습니다.<br>
                    (수집된 개인정보는 담당자 확인 후 폐기처리 됩니다.)<br>
                    ② 회사는 법률에 특별한 규정이 있는 경우를 제외하고는 회원의 별도 동의 없이 회원의 계정정보를 포함한 일체의 개인정보를 제 3자에게 공개하거나 제공하지 아니합니다.

                    <div style="font-weight:bold;margin-top:5px;">제 2조 회원의 의무</div>
                    1. 회원은 다음 각 호에 해당하는 행위를 해서는 안됩니다. 해당 행위로 인한 법적 분쟁시 모든 책임은 회원 본인에게 있습니다.<br>
                    ① 환전 신청 또는 회원정보 변경시 허위내용 등록<br>
                    ② 타인의 정보도용<br>
                    ③ 서비스 이용약관에 위배되는 행위

                    <div style="text-align:center;margin-top:5px;font-weight:bold;"><label><input type="checkbox" name="agree"> 위 내용을 읽고 내용에 동의합니다.</label></div>
                </div>

                <div style="border:1px solid #ddd;margin-top:5px;padding:10px;background-color:#EFEFEF;">
                    <div style="font-weight:bold;">개인정보 수집 및 이용</div>
                    <div style="text-align:center;margin-top:5px;font-weight:bold;"><label><input type="checkbox" name="privacyAgree1"> 동의합니다.</label></div>
                    <table class="privacyTable">
                        <tbody><tr>
                            <th>수집하는 정보의 항목</th>
                            <td>아이디, 비밀번호, 이름, 주민등록번호, 휴대폰번호, 은행명 및 계좌번호, 신분증사본, 통장사본</td>
                        </tr>
                        <tr>
                            <th>개인정보 처리 목적</th>
                            <td>환전서비스 제공 및 사업소득세 신고</td>
                        </tr>
                        <tr>
                            <th>보유 및 이용기간</th>
                            <td>환전 처리 후 별도 보관<br>(환전 후 국세기본법, 전자상거래 등에서의 소비자 보호에 관한 법률 등에 따라 5년 간 보관됩니다)</td>
                        </tr>
                        </tbody></table>
                    <div style="font-size:11px;">* 동의를 거부할 수 있으나, 동의를 거부하는 경우 환전 서비스 이용이 불가합니다.</div>

                    <div style="font-weight:bold;margin-top:15px;">개인정보의 제3자 제공</div>
                    <div style="text-align:center;margin-top:5px;font-weight:bold;"><label><input type="checkbox" name="privacyAgree2"> 동의합니다.</label></div>
                    <table class="privacyTable">
                        <tbody><tr>
                            <th>제공하는 정보의 항목</th>
                            <td>이름, 주민등록번호</td>
                        </tr>
                        <tr>
                            <th>제공하는 목적</th>
                            <td>사업소득세 신고</td>
                        </tr>
                        <tr>
                            <th>보유 및 이용기간</th>
                            <td>법령에서 정한 기간</td>
                        </tr>
                        <tr>
                            <th>제공받는 자</th>
                            <td>국세청</td>
                        </tr>
                        </tbody></table>
                    <div style="font-size:11px;">* 동의를 거부할 수 있으나, 동의를 거부하는 경우 환전 서비스 이용이 불가합니다.</div>
                </div>
                <div style="margin:15px 0;"><input type="submit" class="btn" id="exchangeBtn" value="환전 신청"></div>
            </div>
        </form>
        <table class="logBox table" style="margin-top:5px;">
            <colgroup>
                <col width="50">
                <col width="150">
                <col>
                <col width="150">
                <col width="180">
            </colgroup>

            <tbody><tr class="title">
                <th>번호</th>
                <th>상태</th>
                <th>총알 개수</th>
                <th>환전금액</th>
                <th>일시</th>
            </tr>
            <?php $__currentLoopData = $exchs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($ex["id"]); ?></td>
                <td>
                    <?php if($ex["status"] == 0): ?><?php echo e("신청"); ?><?php endif; ?>
                    <?php if($ex["status"] == 1): ?><?php echo e("승인"); ?><?php endif; ?>
                    <?php if($ex["status"] == 2): ?><?php echo e("거절"); ?><?php endif; ?>
                </td>
                <td>
                    <?php echo e($ex["bullet"]); ?>

                </td>
                <td>
                    <?php echo e($ex["money"]); ?>

                </td>
                <td>
                    <?php echo e($ex["updated_at"]); ?>

                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php echo e($exchs->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/member/powerball-exchange.blade.php ENDPATH**/ ?>
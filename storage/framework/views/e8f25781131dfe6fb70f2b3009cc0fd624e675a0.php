<?php $__env->startSection("content"); ?>
    <?php
    $paramt = "friend";
    if(Request::get("searchVal") == "B")
        $paramt = "block";
    ?>
    <div class="memoBox">
        <?php echo $__env->make("member.memo-memu", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="content">
            <div class="name-search">
                <a href="#" onclick="listDel('<?php echo e($paramt); ?>');return false;"><img src="/assets/images/powerball/btn_del_off.png" width="48" height="24"></a>
                <div class="tooltipBox">
                    친구추가방법<span class="tooltip-btn">?</span>
                </div>
                <span>
					<input type="text" placeholder="친구검색" class="input" id="searchValue" value="<?php echo e(Request::get("nickname")); ?>" onkeypress="if(event.keyCode==13){friendSearch('friendList');return false;}">
					<a href="#" onclick="friendSearch('friendList');return false;"><img src="https://simg.powerballgame.co.kr/images/memo/btn_search_off.png" width="48" height="24"></a>
				</span>
            </div>
            <div class="tooltip-content2" style="display: none;">
                <a href="#" onclick="$('.tooltip-content2').hide();return false;" style="position:absolute;top:2px;right:2px;"><img src="https://simg.powerballgame.co.kr/images/memo/btn_close.png" width="25" height="25"></a>
                <b>친구추가방법</b>
                <div class="desc">
                    게시판 또는 채팅창에서 닉네임을 클릭하시면
                    펼침메뉴가 나오며 해당 펼침메뉴에서 [친구추가]를
                    클릭하시면 친구추가를 하실 수 있습니다.
                </div>
            </div>
            <form name="friendListForm" method="post" action="/processFrd">
                <input type="hidden" name="rtnUrl" value="/memo?type=friendList&searchVal=all">
                <input type="hidden" name="searchVal" id="searchVal">
                <input type="hidden" name="nickname" id="nickname">
                <input type="hidden" name="friendType">
                <?php echo csrf_field(); ?>
                <div class="listBox">
                    <ul>
                        <?php $__currentLoopData = getUserPrefix(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prf_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="<?php echo e($prf_val["class"]); ?>" >
                                <a
                                    <?php if(Request::get("searchVal") == $prf_val["key"] || (empty(Request::get("searchVal")) && $prf_val["key"]== "all")): ?>
                                    class="on"
                                    <?php endif; ?>
                                    href="/memo?type=friendList&searchVal=<?php echo e($prf_val["key"]); ?>"
                                ><?php echo e($prf_val["alias"]); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <table class="table-mail" style="margin-top:5px;">
                    <colgroup>
                        <col width="50">
                        <col width="*">
                        <col width="200">
                    </colgroup>
                    <thead>
                    <tr>
                        <th scope="col"><span class="line"><input type="checkbox" onclick="checkAll(this.checked);"></span></th>
                        <th scope="col"><span class="line">닉네임</span></th>
                        <th scope="col">접속상태</th>
                    </tr>
                    </thead>
                </table>
                <div id="resultDiv">
                    <table class="table-mail" style="position:relative;top:-1px;">
                        <caption></caption>
                        <colgroup>
                            <col width="50">
                            <col width="*">
                            <col width="200">
                        </colgroup>
                        <tbody>
                            <?php if(sizeof($result["list"]) > 0): ?>
                                <?php $__currentLoopData = $result["list"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $frd_usr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td style="text-align:center;"><input type="checkbox" name="check[]" class="check" value="<?php echo e($frd_usr["userIdKey"]); ?>"></td>
                                        <td style="text-align:left;"><img src="<?php echo e($frd_usr["getLevel"]["value3"]); ?>" width="23" height="23"> <strong><?php echo e($frd_usr["nickname"]); ?></strong></td>
                                        <td class="time" style="font-size:11px;"><img src="/assets/images/powerball/offline.gif" width="20" height="20"> 미접속</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php else: ?>
                                <tr>
                                    <td colspan="3">자료가 비였습니다.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>
            <div class="page">
                <?php echo e($result["list"]->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/friendList.blade.php ENDPATH**/ ?>
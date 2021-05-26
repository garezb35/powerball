<div id="footer">
    <dl>
        <dd>
            <a href="?view=agree" target="mainFrame">이용약관</a><span>|</span>
            <a href="?view=agree&amp;type=privacy" target="mainFrame"><strong>개인정보처리방침</strong></a><span>|</span>
            <a href="?view=agree&amp;type=youth" target="mainFrame"><strong>청소년보호정책</strong></a><span>|</span>
            <a href="?view=agree&amp;type=rejectemail" target="mainFrame">이메일주소무단수집거부</a><span>|</span>
            <a href="mailto:help@powerballgame.co.kr">광고 및 제휴문의</a><span>|</span>
            <a href="bbs/board.php?bo_table=custom" target="mainFrame">고객센터</a>
        </dd>
    </dl>
    <p class="small">
        상호 : (주)엠커넥트 <span class="bar">|</span> 대표 : 강효신 <span class="bar">|</span> 사업자등록번호 : 218-86-01356 <span class="bar">|</span> 통신판매업신고 : 제 2019-인천부평-1516호<br>
        주소: 인천광역시 부평구 부평대로 283, 6층 에이-610호(청천동, 부평우림라이온스밸리) <span class="bar">|</span> 이메일 : <a href="mailto:help@powerballgame.co.kr" class="mail">help@powerballgame.co.kr</a> <span class="bar">|</span> FAX : 0303-3447-3737
    </p>
    <p class="copyright">
        Copyright © <a href="https://www.powerballgame.co.kr" target="_blank"><strong>powerballgame.co.kr</strong></a> All rights reserved.
    </p>
</div>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/handlebars.js"></script>
<script src="/assets/popper/popper.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/js/common.js"></script>
<script src="/assets/js/style.js"></script>
<script src="/assets/js/all.js"></script>
<script>
    $(document).ready(function(){
        var noticeTimer = "";
        $('#scrollNotice > ul li a').hover(function(){
            clearInterval(noticeTimer);
        },function(){
            noticeTimer = setInterval("rollingNotice()",3000);
        });

        noticeTimer = setInterval("rollingNotice()",3000);


    })
    function rollingNotice()
    {
        $('#scrollNotice').animate({'top':'-=20'},{
            duration:500,
            easing: "linear",
            complete:function(){
                $('#scrollNotice > ul').children('li:last').after($('#scrollNotice > ul li:eq(0)'));
                $('#scrollNotice').css({'top':0});
            }
        });
    }

</script>

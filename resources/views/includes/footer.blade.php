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
        상호 : {{$prohited["company_alias"]}} <span class="bar">|</span> 대표 : {{$prohited["represent"]}} <span class="bar">|</span> 사업자등록번호 : {{$prohited["business"]}} <span class="bar"><br>
        주소: {{$prohited["company_address"]}} <span class="bar">|</span> 이메일 : <a href="mailto:{{$prohited["email"]}}" class="mail">{{$prohited["email"]}}</a> <span class="bar">|</span> 전화번호 : {{$prohited["company_phone"]}}
    </p>
    <p class="copyright">
        Copyright © <a href="{{$prohited["site_address"]}}" target="_blank"><strong>{{$prohited["site_address"]}}</strong></a> All rights reserved.
    </p>
</div>

<script src="/assets/js/handlebars.js"></script>
<script src="/assets/popper/popper.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/js/common.js"></script>
<script src="/assets/js/style.js"></script>
<script src="/assets/js/all.js"></script>

<ul class="nav nav-pills nav-fill poweeball-menu">
    <li class="nav-item">
        <a class="nav-link border-right-0 <?php if( (Request::get('terms') =="lates" && Request::get('pageType') =="display") || (Request::get('terms') =="lates" && empty(Request::get('pageType')))): ?> active <?php endif; ?>" href="/p_analyse?terms=lates&pageType=display">파워볼 중계</a>

    </li>
    <li class="nav-item">
        <a class="nav-link border-right-0  <?php if( Request::get('terms') =="period" || Request::get('terms') =="date"): ?> active <?php endif; ?>" href="/p_analyse?terms=date">일자별 분석</a>
    </li>
    <li class="nav-item">
        <a class="nav-link border-right-0 <?php if( (Request::get('terms') =="round" || Request::get('terms') =="roundbox") || (Request::get('terms') =="lates" && Request::get('pageType') =="late")): ?> active <?php endif; ?>" href="/p_analyse?terms=round">회차별 분석</a>
    </li>

    <li class="nav-item">
        <a class="nav-link <?php if( Request::get('terms') =="pattern"): ?> active <?php endif; ?>" href="/p_analyse?terms=pattern">패턴별 분석</a>
    </li>
</ul>
<?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/Analyse/analyse-menu.blade.php ENDPATH**/ ?>
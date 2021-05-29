<ul class="nav nav-pills nav-fill poweeball-menu">
    <li class="nav-item">
        <a class="nav-link <?php if( Request::get('terms') =="lates" && Request::get('pageType') =="display"): ?> active <?php endif; ?>" href="/psadari_analyse?terms=lates&pageType=display">파워사다리중계</a>

    </li>
    <li class="nav-item">
        <a class="nav-link <?php if( Request::get('terms') =="period" || Request::get('terms') =="date"): ?> active <?php endif; ?>" href="/psadari_analyse?terms=period">일별분석</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if( (Request::get('terms') =="round" || Request::get('terms') =="roundbox") || (Request::get('terms') =="lates" && Request::get('pageType') =="late")): ?> active <?php endif; ?>" href="/psadari_analyse?terms=round">회차분석</a>
    </li>

    <li class="nav-item">
        <a class="nav-link <?php if( Request::get('terms') =="pattern"): ?> active <?php endif; ?>" href="/psadari_analyse?terms=pattern">패턴분석</a>
    </li>
</ul>
<?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/Analyse/psadari/analyse-menu.blade.php ENDPATH**/ ?>
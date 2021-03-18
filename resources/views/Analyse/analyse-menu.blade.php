<ul class="nav nav-pills nav-fill poweeball-menu">
    <li class="nav-item">
        <a class="nav-link @if ( Request::get('terms') =="lates" && Request::get('pageType') =="display") active @endif" href="/p_analyse?terms=lates&pageType=display">파워볼중계</a>

    </li>
    <li class="nav-item">
        <a class="nav-link @if ( Request::get('terms') =="period" || Request::get('terms') =="date") active @endif" href="/p_analyse?terms=period">일별분석</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if ( (Request::get('terms') =="round" || Request::get('terms') =="roundbox") || (Request::get('terms') =="lates" && Request::get('pageType') =="late")) active @endif" href="/p_analyse?terms=round">회차분석</a>
    </li>

    <li class="nav-item">
        <a class="nav-link @if ( Request::get('terms') =="pattern") active @endif" href="/p_analyse?terms=pattern">패턴분석</a>
    </li>
</ul>

<ul class="nav nav-pills nav-fill poweeball-menu">
    <li class="nav-item">
        <a class="nav-link border-right-0 @if ( (Request::get('terms') =="lates" && Request::get('pageType') =="display") || (Request::get('terms') =="lates" && empty(Request::get('pageType')))) active @endif" href="/p_analyse?terms=lates&pageType=display">파워볼 중계</a>

    </li>
    <li class="nav-item">
        <a class="nav-link border-right-0  @if ( Request::get('terms') =="period" || Request::get('terms') =="date") active @endif" href="/p_analyse?terms=date">일자별 분석</a>
    </li>
    <li class="nav-item">
        <a class="nav-link border-right-0 @if ( (Request::get('terms') =="round" || Request::get('terms') =="roundbox") || (Request::get('terms') =="lates" && Request::get('pageType') =="late")) active @endif" href="/p_analyse?terms=round">회차별 분석</a>
    </li>

    <li class="nav-item">
        <a class="nav-link @if ( Request::get('terms') =="pattern") active @endif" href="/p_analyse?terms=pattern">패턴별 분석</a>
    </li>
</ul>

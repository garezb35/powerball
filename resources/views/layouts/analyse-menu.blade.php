<table width="100%" border="0" class="defaultTable">
    <colgroup>
        <col width="25%">
        <col width="25%">
        <col width="25%">
        <col width="25%">
    </colgroup>
    <tbody>
    <tr>
        <th class="menu on position-relative" style="position:relative;">
            <a href="{{ route('p_analyse') }}?terms=date" class="tab1 on">일자별 분석
                <div style="position:absolute;top:0px;left:20px;">
                    <img src="https://simg.powerballgame.co.kr/images/realtime_bt.gif" width="37" height="19">
                </div>
            </a>
        </th>
        <th class="menu">
            <a href="{{ route('p_analyse') }}?terms=lates" class="tab2">최근 분석
                <div style="position:absolute;top:0px;left:20px;">
                    <img src="https://simg.powerballgame.co.kr/images/realtime_bt.gif" width="37" height="19">
                </div>
            </a>
        </th>
        <th class="menu"><a href="{{ route('p_analyse') }}?terms=period" class="tab3">기간별 분석</a></th>
        <th class="menu"><a href="{{ route('p_analyse') }}?terms=pattern" class="tab5">패턴별 분석</a></th>
    </tr>
    </tbody>
</table>
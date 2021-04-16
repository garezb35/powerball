<div class="collapse-div position-relative">
    <h5 class="text-center">회차별 분석 데이터 <div class="half-label"></div></h5>
    <div style="width: 99%;margin: auto">
        <table  id="powerballLogBox" class="powerballBox table table-bordered mt-2">
            <colgroup>
                <col width="9%" />
                <col width="8%" />
                <col width="8%" />
                <col width="8%" />
                <col width="8%" />
                <col width="8%" />
                <col width="12%" />
                <col width="5%" />
                <col width="9%" />
                <col width="10%" />
                <col width="7%" />
                <col width="8%" />
            </colgroup>
            <tbody class="see-t">
            <tr class="subTitle">

                <td height="30" colspan="6">파워볼</td>
                <td colspan="6">숫자</td>
            </tr>
            <tr class="thirdTitle">
                <td class="p-3">회차</td>
                <td class="p-3">시간</td>
                <td class="p-3" height="30">결과</td>
                <td class="p-3">구간</td>
                <td class="p-3">홀짝</td>
                <td class="p-3">언더/오버</td>
                <td class="p-3">결과</td>
                <td class="p-3">합</td>
                <td class="p-3">구간</td>
                <td class="p-3">대/중/소</td>
                <td class="p-3">홀짝</td>
                <td class="p-3">언더/오버</td>
            </tr>
            </tbody>
        </table>
        <div class="displayNone text-center d-none" id="pageDiv" pageval="6" round="1065675">
            <img src="https://simg.powerballgame.co.kr/images/loading2.gif" width="50" height="50">
        </div>
        <div class="moreBox"><a href="#" onclick="moreClick();return false;">더보기</a></div>
    </div>

</div>


<script id="see-data" type="text/x-handlebars-template">
    {{#each this}}
    <tr>
        <td height="40" align="center">
            <span class="numberText">{{this.day_round}}회</span><br />
            ( <span class="numberText">{{this.round}}회</span> )
        </td>
        <td align="center" class="numberText">{{#displayTime this.created_date}}{{/displayTime}}</td>
        <td align="center" class="numberText"><div class="sp-ball_bg">{{this.pb}}</div></td>
        <td align="center" class="numberText">{{#npTerm this.pb 1}}{{/npTerm}}</td>
        <td align="center">{{#ifEquals this.pb_oe '1'}}<div class="sp-odd">홀</div>{{/ifEquals}} {{#ifEquals this.pb_oe '0'}}<div class="sp-even">짝</div>{{/ifEquals}}</td>
        <td align="center"><div class="{{#ifEquals this.pb_uo '1'}}sp-under{{/ifEquals}} {{#ifEquals this.pb_uo '0'}}sp-over{{/ifEquals}}"></div></td>
        <td align="center" class="numberText">{{this.nb1}},{{this.nb2}},{{this.nb3}},{{this.nb4}},{{this.nb5}}</td>
        <td align="center" class="numberText">{{this.nb}}</td>
        <td align="center" class="numberText">{{#npTerm this.nb 2}}{{/npTerm}}</td>
        <td align="center" class="numberText">{{#nbSize this.nb}}{{/nbSize}}</td>
        <td align="center">{{#ifEquals this.nb_oe '1'}}<div class="sp-odd">홀</div>{{/ifEquals}} {{#ifEquals this.nb_oe '0'}}<div class="sp-even">짝</div>{{/ifEquals}}</td>
        <td align="center"><div class="{{#ifEquals this.nb_uo '1'}}sp-under{{/ifEquals}} {{#ifEquals this.nb_uo '0'}}sp-over{{/ifEquals}}"></div></td>
    </tr>
    {{/each}}
</script>

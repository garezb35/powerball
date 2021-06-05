<div class="collapse-div position-relative">
    <h5 class="text-center" style="font-size: 18px;">회차별 분석 데이터 <div class="half-label" style="width: 141px;"></div></h5>
    <div style="width: 95%;margin: auto">
        <table  id="powerballLogBox" class="powerballBox table table-bordered mt-2 table-striped-saddari">
            <tbody class="see-t">
                <tr class="subTitle pheader">
                    <td class="p-3">회차</td>
                    <td class="p-3">시간</td>
                    <td class="p-3">시작</td>
                    <td class="p-3">줄수</td>
                    <td class="p-3">결과</td>
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
        <td align="center" class="numberText"><div class="sp-{{this.sadari.start}}">{{#ifEquals this.sadari.start "LEFT"}}좌{{else}}우{{/ifEquals}}</div></td>
        <td align="center" class="numberText"><div class="sp{{this.sadari.startlines}}">{{#ifEquals this.sadari.startlines "_3"}}3{{else}}4{{/ifEquals}}</div></td>
        <td align="center" class="numberText"><div class="sp-{{this.sadari.startoe}}">{{#ifEquals this.sadari.startoe "odd"}}홀{{else}}짝{{/ifEquals}}</div></td>
    </tr>
    {{/each}}
</script>

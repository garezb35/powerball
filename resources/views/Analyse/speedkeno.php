<table  id="speedkenoLogBox" class="powerballBox table table-bordered table-striped" style="margin-top: 5px;">
    <colgroup>
        <col width="10%" />
        <col width="8%" />
        <col width="52%" />
        <col width="10%" />
        <col width="10%" />
        <col width="10%" />
    </colgroup>
    <tbody>
    <tr>
        <th height="30" colspan="6" class="title" style="position: relative;">
            회차별 분석 데이터<span style="position: absolute; top: 6px; right: 10px; color: #969696;" class="siteLink">copyright <a href="/?referer=speedkeno" target="_blank" class="titleCopy">powerballgame.co.kr</a></span>
        </th>
    </tr>
    <tr class="subTitle">
        <th height="60" rowspan="2">회차</th>
        <th rowspan="2">시간</th>
        <th height="30" colspan="2">결과</th>
        <th colspan="2">숫자합 마지막자리</th>
    </tr>
    <tr class="thirdTitle">
        <th height="30">숫자</th>
        <th>숫자합</th>
        <th>홀짝</th>
        <th>언더오버</th>
    </tr>
    </tbody>
    <tbody class="see-t">

    </tbody>
</table>
<script id="see-data" type="text/x-handlebars-template">
    {{#each this}}
    <tr class="trOdd">
        <td height="40" align="center">
            <span class="numberText">{{this.day_round}}회</span><br />
            ( <span class="numberText">{{this.round}}회</span> )
        </td>
        <td align="center" class="numberText">{{#displayTime this.created_date}}{{/displayTime}}</td>
        <td align="center" class="numberText">{{this.sum_list}}</td>
        <td align="center" class="numberText">{{this.speed_sum}}</td>
        <td align="center"><img src="https://www.powerballgame.co.kr/images/{{#ifEquals this.speed_oe '1'}}odd{{/ifEquals}}{{#ifEquals this.speed_oe '0'}}even{{/ifEquals}}.png" width="29" height="29" /></td>
        <td align="center"><img src="https://www.powerballgame.co.kr/images/{{#ifEquals this.speed_uo '1'}}under{{/ifEquals}}{{#ifEquals this.speed_uo '0'}}over{{/ifEquals}}.png" width="34" height="29" /></td>
    </tr>
    {{/each}}
</script>

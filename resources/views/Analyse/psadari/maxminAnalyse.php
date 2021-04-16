<table  style="margin-top: 10px;" class="powerballBox table table-bordered">
    <colgroup>
        <col width="15%" />
        <col width="13%" />
        <col width="13%" />
        <col width="13%" />
        <col width="13%" />
        <col width="13%" />
        <col width="13%" />
    </colgroup>
    <thead class="border-jinblue jin-gradient">
        <tr>
            <th height="30" colspan="7" style="position: relative;">
                검색 기간내 최대/최소 출현 통계데이터
            </th>
        </tr>
    </thead>
    <tbody class="minmax-t">
        <tr class="thirdTitle">
            <th height="40"></th>
            <th class="border-right-none">최다훌현횟수</th>
            <th class="border-right-none border-left-none">출현률</th>
            <th class="border-left-none">출현날짜</th>
            <th class="border-right-none">최소훌현횟수</th>
            <th class="border-right-none border-left-none">출현률</th>
            <th class="border-left-none">출현날짜</th>


        </tr>

    </tbody>
</table>

<script id="minmax-data" type="text/x-handlebars-template">
    {{#each this}}
    <tr>
        <td class="border-top-none border-bottom-none" height="35" align="center">
            {{#ifEquals @index 0}}파워볼 홀{{/ifEquals}}
            {{#ifEquals @index 1}}파워볼 짝{{/ifEquals}}
            {{#ifEquals @index 2}}일반볼합 홀{{/ifEquals}}
            {{#ifEquals @index 3}}일반볼합 짝{{/ifEquals}}
            {{#ifEquals @index 4}}대{{/ifEquals}}
            {{#ifEquals @index 5}}중{{/ifEquals}}
            {{#ifEquals @index 6}}소{{/ifEquals}}
        </td>
        {{#each this}}
        <td class="border-top-none border-bottom-none border-right-none border-left-none" align="center"><span class="evenText{{@index}} font-weight-bold">{{this.counts}}</span></td>
        <td class="border-top-none border-bottom-none border-right-none border-left-none" align="center"><span>{{#perOfDay this.counts}}{{/perOfDay}}%</span></td>
        <td class="border-top-none border-bottom-none border-right-none border-left-none" align="center"><span class="date">{{this.date}}</span></td>
        {{/each}}
    </tr>
    {{/each}}
</script>

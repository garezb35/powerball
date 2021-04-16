<div class ="collapse-div position-relative pb-0">
    <h5 class="text-center">검색 기간내 최대/최소 출현 통계데이터
        <div class="half-label"></div></h5>
    <button class="position-absolute closing" data-toggle="collapse" data-target="#seeaya" aria-expanded="true">닫기</button>
    <div class="collapse show collapsing-element" id="seeaya">
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
    </div>
</div>


<script id="minmax-data" type="text/x-handlebars-template">
    {{#each this as  |v key|}}
    <tr>
        <td height="35" align="center" class="thirdTitle {{#ifEquals key '1/3'}}border-bottom-bora{{/ifEquals}}">
            {{#ifEquals key 0}}좌{{/ifEquals}}
            {{#ifEquals key 1}}우{{/ifEquals}}
            {{#ifEquals key 2}}3{{/ifEquals}}
            {{#ifEquals key 3}}4{{/ifEquals}}
            {{#ifEquals key 4}}홀{{/ifEquals}}
            {{#ifEquals key 5}}짝{{/ifEquals}}
            {{#ifEquals key 6}}좌4홀{{/ifEquals}}
            {{#ifEquals key 7}}우3홀{{/ifEquals}}
            {{#ifEquals key 8}}좌3짝{{/ifEquals}}
            {{#ifEquals key 9}}우4짝{{/ifEquals}}
        </td>
        {{#each this}}
        <td  align="center" class="{{#ifEquals key '1/3'}}border-bottom-bora{{/ifEquals}}"><span class="evenText{{@index}} font-weight-bold">{{this.counts}}</span></td>
        <td  align="center" class="{{#ifEquals key '1/3'}}border-bottom-bora{{/ifEquals}}"><span>{{#perOfDay this.counts}}{{/perOfDay}}%</span></td>
        <td  align="center" class="{{#ifEquals key '1/3'}}border-bottom-bora{{/ifEquals}}"><span class="date">{{this.date}}</span></td>
        {{/each}}
    </tr>
    {{/each}}
</script>

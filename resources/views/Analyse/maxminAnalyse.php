<div class ="collapse-div position-relative pb-0 ">
    <h5 class="text-center" style="font-size: 18px">검색 기간내 최대/최소 출현 통계데이터
        <div class="half-label" style="width: 290px"></div></h5>
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
            <tr>
                <th height="40"></th>
                <th>최다훌현횟수</th>
                <th>출현률</th>
                <th class="border-right-bora">출현날짜</th>
                <th>최소훌현횟수</th>
                <th>출현률</th>
                <th>출현날짜</th>
            </tr>
            </tbody>
        </table>
        <table  id="ladderLogBox" class="powerballBox table table-bordered mt-1 mb-0">
            <colgroup>
                <col width="10%" />
                <col width="8%" />
                <col width="8%" />
                <col width="8%" />
                <col width="8%" />
                <col width="8%" />
                <col width="8%" />
                <col width="8%" />
                <col width="8%" />
                <col width="8%" />
                <col width="8%" />
                <col width="8%" />
            </colgroup>
            <thead>
            <tr class="thirdTitle">
                <th height="80" rowspan="2" class="border-left-0">날짜</th>
                <th colspan="4">파워볼</th>
                <th colspan="7" class="border-right-0">일반볼합</th>
            </tr>
            <tr class="thirdTitle">
                <th>홀</th>
                <th>짝</th>
                <th>언더</th>
                <th>오버</th>
                <th>홀</th>
                <th>짝</th>
                <th>언더</th>
                <th>오버</th>
                <th>대</th>
                <th>중</th>
                <th class="border-right-0">소</th>
            </tr>
            </thead>
            <tbody class = "minmaxday-t">
            </tbody>
        </table>
    </div>
</div>


<script id="minmax-data" type="text/x-handlebars-template">
    {{#each this as  |v key|}}
    <tr >
        <td height="35" align="center" class="thirdTitle {{#ifEquals key '1/3'}}border-bottom-bora{{/ifEquals}}">
            {{#ifEquals key 0}}파워볼 홀{{/ifEquals}}
            {{#ifEquals key 1}}파워볼 짝{{/ifEquals}}
            {{#ifEquals key 2}}일반볼합 홀{{/ifEquals}}
            {{#ifEquals key 3}}일반볼합 짝{{/ifEquals}}
            {{#ifEquals key 4}}대{{/ifEquals}}
            {{#ifEquals key 5}}중{{/ifEquals}}
            {{#ifEquals key 6}}소{{/ifEquals}}
        </td>
        {{#each this}}
        <td  align="center" class="{{#ifEquals key '1/3'}}border-bottom-bora{{/ifEquals}}"><span class="evenText{{@index}} font-weight-bold">{{this.counts}}</span></td>
        <td  align="center" class="{{#ifEquals key '1/3'}}border-bottom-bora{{/ifEquals}}"><span>{{#perOfDay this.counts}}{{/perOfDay}}%</span></td>
        <td  align="center" class="{{#ifEquals key '1/3'}}border-bottom-bora{{/ifEquals}} {{#ifEquals @index '0'}}border-right-bora{{/ifEquals}}"><span class="date">{{this.date}}</span></td>
        {{/each}}
    </tr>
    {{/each}}
</script>

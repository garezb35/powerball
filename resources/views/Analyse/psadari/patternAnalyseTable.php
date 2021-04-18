<?php $from = empty($from) ? "" : $from ?>
<?php $to = empty($to) ? "" : $to ?>
<?php $limit = empty($limit) ? "" : $limit ?>
<div class ="collapse-div position-relative pb-0">
    <h5 class="text-center" style="font-size: 18px">패턴별 분석 데이터 <div class="half-label" style="width: 140px"></div></h5>
    <button class="position-absolute closing" data-toggle="collapse" data-target="#peod" aria-expanded="true">닫기</button>
    <div class="collapse show collapsing-element" id="peod">
        <table class="table table-bordered jabik" id="patternBox-head">
            <colgroup>
                <col width="25%">
                <col width="25%">
                <col width="25%">
                <col width="25%">
            </colgroup>
            <tbody>
            <tr>
                <th height="30" class="btns">
                    <a href="#" onclick="ajaxPattern('left_right','<?=$from?>','<?=$to?>','<?=$limit?>');return false;" class="tab1" type="left_right">출발 패턴</a>
                </th>
                <th class="btns">
                    <a href="#" onclick="ajaxPattern('three_four','<?=$from?>','<?=$to?>','<?=$limit?>');return false;" class="tab2" type="three_four">줄수패턴</a>
                </th>
                <th class="btns">
                    <a href="#" onclick="ajaxPattern('odd_even','<?=$from?>','<?=$to?>','<?=$limit?>');return false;" class="tab1" type="odd_even">홀짝패턴</a>
                </th>
                <th class="btns">
                    <a href="#" onclick="ajaxPattern('total','<?=$from?>','<?=$to?>','<?=$limit?>');return false;" class="tab2" type="total">출줄패턴</a>
                </th>
            </tr>
        </table>
        <table class="table table-bordered" id="patternBox">
            <tr>
                <td colspan="4" class="align-middle border-none"">
                    <ul class="info" id="head-info">

                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="4"  class="p-0 border-none">
                    <div class="content pattern-t">

                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


<script id="pattern-date" type="text/x-handlebars-template">
    <table class="patternTable">
        <tbody>
            <tr>
                {{#each list as |child childIndex|}}
                <td class="border-none p-none">
                    <table class="innerTable">
                        <tbody>
                        <tr>
                            <th class="title_{{child.type}}">{{child.alias}}</th>
                        </tr>
                        {{#each child.list as |pick pickIndex|}}
                        <tr>
                            <td><div class="{{child.type}}">{{pick}}</div></td>
                        </tr>
                        {{/each}}
                        {{#times @root.max child.list.length}}
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        {{/times}}

                        <tr>
                            <td class="sum">{{child.list.length}}</td>
                        </tr>
                        <tr>
                            <td class="order">{{inc @childIndex}}</td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                {{/each}}
            </tr>
        </tbody>
    </table>
</script>




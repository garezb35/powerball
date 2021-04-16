<?php $from = empty($from) ? "" : $from ?>
<?php $to = empty($to) ? "" : $to ?>
<?php $limit = empty($limit) ? "" : $limit ?>
<div class ="collapse-div position-relative pb-0">
    <h5 class="text-center">패턴별 분석 데이터 <div class="half-label"></div></h5>
    <button class="position-absolute closing" data-toggle="collapse" data-target="#peod" aria-expanded="true">닫기</button>
    <div class="collapse show collapsing-element" id="peod">
        <table class="table table-bordered" id="patternBox-head">
            <colgroup>
                <col width="20%">
                <col width="20%">
                <col width="20%">
                <col width="20%">
                <col width="20%">
            </colgroup>
            <tbody>
                <tr class="subTitle">
                    <th height="30" colspan="2">파워볼 기준</th>
                    <th colspan="3">숫자합 기준</th>
                </tr>
                <tr>
                    <th height="30" class="btns"><a href="#" onclick="ajaxPattern('pb_oe','<?=$from?>','<?=$to?>','<?=$limit?>');return false;" class="tab1" type="pb_oe">홀짝 패턴</a></th>
                    <th class="btns"><a href="#" onclick="ajaxPattern('pb_uo','<?=$from?>','<?=$to?>','<?=$limit?>');return false;" class="tab2" type="pb_uo">언더오버 패턴</a></th>
                    <th class="btns"><a href="#" onclick="ajaxPattern('nb_oe','<?=$from?>','<?=$to?>','<?=$limit?>');return false;" class="tab1" type="nb_oe">홀짝 패턴</a></th>
                    <th class="btns"><a href="#" onclick="ajaxPattern('nb_uo','<?=$from?>','<?=$to?>','<?=$limit?>');return false;" class="tab2" type="nb_uo">언더오버 패턴</a></th>
                    <th class="btns"><a href="#" onclick="ajaxPattern('nb_size','<?=$from?>','<?=$to?>','<?=$limit?>');return false;" class="tab3" type="nb_size">대중소 패턴</a></th>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered mb-0" id="patternBox">
            <tbody>
                <tr>
                    <td class="align-middle" style="border-bottom: none">
                        <ul class="info" id="head-info">

                        </ul>
                    </td>
                </tr>
                <tr>
                    <td style="border-top: none;border-right: none" class="p-0">
                        <div class="content pattern-t">

                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<script id="pattern-date" type="text/x-handlebars-template">
    <table class="patternTable border-top-bora">
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




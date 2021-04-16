<div style="border: 1px solid #e9ecef;border-radius: 5px">
    <table  class="table" id="sixBox">
        <colgroup>
            <col width="20%" />
            <col width="20%" />
            <col width="20%" />
            <col width="20%" />
            <col width="20%" />
        </colgroup>
        <tbody>
            <tr class="subTitle patternCnt">
                <th colspan="5" class="p-0 border-none">
                    <ul class="nav nav-tabs" id="boardmenu-sec" role="tablist">
                        <li class="nav-item">
                            <a href="#" onclick="return false;" rel="6" class="on1 nav-link">6매</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="return false;" rel="5" class="nav-link">5매</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="return false;" rel="4" class="nav-link">4매</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="return false;" rel="3" class="nav-link">3매</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="return false;" rel="2" class="nav-link">2매</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="return false;" rel="1" class="nav-link">1매</a>
                        </li>
                    </ul>
                </th>
            </tr>
            <tr class="patternType">
                <td colspan="5">
                    <ul id="pattern_six_tab" class="sub_tab">
                        <li class="btns">
                            <a href="#" onclick="return false;" rel="pb_oe" division="powerball" sixtype="pb_oe" class="on2">파워볼 홀짝</a>
                        </li>
                        <li class="btns">
                            <a href="#" onclick="return false;" rel="pb_uo" division="powerball" sixtype="pb_uo">파워볼 언더오버</a>
                        </li>
                        <li class="btns">
                            <a href="#" onclick="return false;" rel="nb_oe" division="number" sixtype="nb_oe">숫자합 홀짝</a>
                        </li>
                        <li class="btns">
                            <a href="#" onclick="return false;" rel="nb_uo" division="number" sixtype="nb_uo">숫자합 언더오버</a>
                        </li >
                        <li class="btns">
                            <a href="#" onclick="return false;" rel="nb_size" division="number" sixtype="nb_size">숫자합 대중소</a>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="5" style="border-top: 1px solid #d5d5d5;">
                    <div class="content six-t">

                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script id="six-data" type="text/x-handlebars-template">
    <table class="patternTable">
        <tbody>
        <tr>
            {{#each list as |child childIndex|}}
            <td class="border-0 p-none">
                <table class="innerTable">
                    <tbody>
                    {{#each child}}
                    <tr>
                        <td><div class="{{this.class}}" title="{{this.alias}}">{{this.round}}</div></td>
                    </tr>
                    {{/each}}
                    {{#times ../step child.length}}
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    {{/times}}
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

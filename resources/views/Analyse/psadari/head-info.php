<script id="pattern-info" type="text/x-handlebars-template">
    {{#ifEquals this.type "pb_oe/nb_oe"}}
    <li class="odd"><span class="ic sp-odd">좌</span><p class="tx"><strong>{{#index_of this.count 1}}{{/index_of}}번</strong> ({{#returnPer this.count 1}}{{/returnPer}}%) {{#index_of this.max 1}}{{/index_of}}연속</p></li>
    <li class="even"><span class="ic sp-even">우</span><p class="tx"><strong>{{#index_of this.count 0}}{{/index_of}}번</strong> ({{#returnPer this.count 0}}{{/returnPer}}%) {{#index_of this.max 0}}{{/index_of}}연속</p></li>
    {{/ifEquals}}

    {{#ifEquals this.type "pb_uo/nb_uo"}}
    <li class="odd"><span class="ic sp-under"></span><p class="tx"><strong>{{#index_of this.count 1}}{{/index_of}}번</strong> ({{#returnPer this.count 1}}{{/returnPer}}%) {{#index_of this.max 1}}{{/index_of}}연속</p></li>
    <li class="even"><span class="ic sp-over"></span><p class="tx"><strong>{{#index_of this.count 0}}{{/index_of}}번</strong> ({{#returnPer this.count 0}}{{/returnPer}}%) {{#index_of this.max 0}}{{/index_of}}연속</p></li>
    {{/ifEquals}}

    {{#ifEquals this.type "left_right"}}
    <li class="odd"><span class="ic sp-odd">좌</span><p class="tx"><strong>{{this.count.LEFT}}번</strong> ({{#returnPerSadari this.count "LEFT"}}{{/returnPerSadari}}%) {{this.max.LEFT}}연속</p></li>
    <li class="even"><span class="ic sp-even">우</span><p class="tx"><strong>{{this.count.RIGHT}}번</strong>({{#returnPerSadari this.count "RIGHT"}}{{/returnPerSadari}}%) {{this.max.RIGHT}}연속</p></li>
    {{/ifEquals}}

    {{#ifEquals this.type "three_four"}}
    <li class="odd"><span class="ic sp-odd">3</span><p class="tx"><strong>{{this.count._3}}번</strong> ({{#returnPerSadari this.count "_3"}}{{/returnPerSadari}}%) {{this.max._3}}연속</p></li>
    <li class="even"><span class="ic sp-even">4</span><p class="tx"><strong>{{this.count._4}}번</strong>({{#returnPerSadari this.count "_4"}}{{/returnPerSadari}}%) {{this.max._4}}연속</p></li>
    {{/ifEquals}}

    {{#ifEquals this.type "odd_even"}}
    <li class="odd"><span class="ic sp-odd">홀</span><p class="tx"><strong>{{this.count.odd}}번</strong> ({{#returnPerSadari this.count "odd"}}{{/returnPerSadari}}%) {{this.max.odd}}연속</p></li>
    <li class="even"><span class="ic sp-even">짝</span><p class="tx"><strong>{{this.count.even}}번</strong>({{#returnPerSadari this.count "even"}}{{/returnPerSadari}}%) {{this.max.even}}연속</p></li>
    {{/ifEquals}}

    {{#ifEquals this.type "total"}}
    <li class="odd"><span class="ic sp-odd">좌4</span><p class="tx"><strong>{{this.count.LEFT4ODD}}번</strong> ({{#returnPerSadari this.count "LEFT4ODD"}}{{/returnPerSadari}}%) {{this.max.LEFT4ODD}}연속</p></li>
    <li class="odd"><span class="ic sp-odd">우3</span><p class="tx"><strong>{{this.count.RIGHT3ODD}}번</strong>({{#returnPerSadari this.count "RIGHT3ODD"}}{{/returnPerSadari}}%) {{this.max.RIGHT3ODD}}연속</p></li>
    <li class="even"><span class="ic sp-even">좌3</span><p class="tx"><strong>{{this.count.LEFT3EVEN}}번</strong>({{#returnPerSadari this.count "LEFT3EVEN"}}{{/returnPerSadari}}%) {{this.max.LEFT3EVEN}}연속</p></li>
    <li class="even"><span class="ic sp-even">우4</span><p class="tx"><strong>{{this.count.RIGHT4EVEN}}번</strong>({{#returnPerSadari this.count "RIGHT4EVEN"}}{{/returnPerSadari}}%) {{this.max.RIGHT4EVEN}}연속</p></li>
    {{/ifEquals}}

    {{#ifEquals this.type "nb_size"}}
    <li class="odd"><span class="ic sp-big">대</span><p class="tx"><strong>{{#index_of this.count 3}}{{/index_of}}번</strong> ({{#returnPer this.count 3}}{{/returnPer}}%) {{#index_of this.max 3}}{{/index_of}}연속</p></li>
    <li class="even"><span class="ic sp-middle">중</span><p class="tx"><strong>{{#index_of this.count 2}}{{/index_of}}번</strong> ({{#returnPer this.count 2}}{{/returnPer}}%) {{#index_of this.max 2}}{{/index_of}}연속</p></li>
    <li class="even"><span class="ic sp-small">소</span><p class="tx"><strong>{{#index_of this.count 1}}{{/index_of}}번</strong> ({{#returnPer this.count 1}}{{/returnPer}}%) {{#index_of this.max 1}}{{/index_of}}연속</p></li>
    {{/ifEquals}}
    {{#ifEquals this.type "total"}}
    {{else}}
    <li class="etc break"><span class="ic sp-black">꺽음</span><p class="tx">{{this.change}}번</p></li>
    {{/ifEquals}}
    {{#ifEquals this.type "pb_uo/nb_uo/pb_oe/nb_oe/left_right/odd_even/three_four"}}
    <li class="etc pongdang"><span class="ic sp-pung">퐁당</span><p class="tx">{{this.pung}}번</p></li>
    {{/ifEquals}}
</script>

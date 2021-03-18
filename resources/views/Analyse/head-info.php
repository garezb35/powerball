<script id="pattern-info" type="text/x-handlebars-template">
    {{#ifEquals this.type "pb_oe/nb_oe"}}
    <li class="odd"><span class="ic sp-odd">홀</span><p class="tx"><strong>{{#index_of this.count 1}}{{/index_of}}번</strong> ({{#returnPer this.count 1}}{{/returnPer}}%) {{#index_of this.max 1}}{{/index_of}}연속</p></li>
    <li class="even"><span class="ic sp-even">짝</span><p class="tx"><strong>{{#index_of this.count 0}}{{/index_of}}번</strong> ({{#returnPer this.count 0}}{{/returnPer}}%) {{#index_of this.max 0}}{{/index_of}}연속</p></li>
    {{/ifEquals}}

    {{#ifEquals this.type "pb_uo/nb_uo"}}
    <li class="odd"><span class="ic sp-under"></span><p class="tx"><strong>{{#index_of this.count 1}}{{/index_of}}번</strong> ({{#returnPer this.count 1}}{{/returnPer}}%) {{#index_of this.max 1}}{{/index_of}}연속</p></li>
    <li class="even"><span class="ic sp-over"></span><p class="tx"><strong>{{#index_of this.count 0}}{{/index_of}}번</strong> ({{#returnPer this.count 0}}{{/returnPer}}%) {{#index_of this.max 0}}{{/index_of}}연속</p></li>
    {{/ifEquals}}

    {{#ifEquals this.type "nb_size"}}
    <li class="odd"><span class="ic sp-big">대</span><p class="tx"><strong>{{#index_of this.count 3}}{{/index_of}}번</strong> ({{#returnPer this.count 3}}{{/returnPer}}%) {{#index_of this.max 3}}{{/index_of}}연속</p></li>
    <li class="even"><span class="ic sp-middle">중</span><p class="tx"><strong>{{#index_of this.count 2}}{{/index_of}}번</strong> ({{#returnPer this.count 2}}{{/returnPer}}%) {{#index_of this.max 2}}{{/index_of}}연속</p></li>
    <li class="even"><span class="ic sp-small">소</span><p class="tx"><strong>{{#index_of this.count 1}}{{/index_of}}번</strong> ({{#returnPer this.count 1}}{{/returnPer}}%) {{#index_of this.max 1}}{{/index_of}}연속</p></li>
    {{/ifEquals}}

    <li class="etc break"><span class="ic sp-black">꺽음</span><p class="tx">{{this.change}}번</p></li>

    {{#ifEquals this.type "pb_uo/nb_uo/pb_oe/nb_oe"}}
    <li class="etc pongdang"><span class="ic sp-pung">퐁당</span><p class="tx">{{this.pung}}번</p></li>
    {{/ifEquals}}
</script>

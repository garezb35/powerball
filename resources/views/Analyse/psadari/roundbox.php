<script id="roundbox-data" type="text/x-handlebars-template">
    <tr>
        <td height="51" width="100px">회차</td>
        {{#each terms}}
        <td>{{this}}</td>
        {{/each}}
    </tr>
    {{#each this.list as |child childKey|}}
    <tr>
        <td height="51" class="p-0">{{@childKey}}</td>
        {{#each ../this.terms as |sec secKey|}}
        <td class="text-center p-0 content"><div class="{{#index_ofWithKey child sec "class"}}{{/index_ofWithKey}}">{{#index_ofWithKey child sec "alias"}}{{/index_ofWithKey}}</div></td>
        {{/each}}
    </tr>
    {{/each}}

    {{#ifEquals this.type "odd_even"}}
    <tr>
        <td><div class="sp-odd">홀</div></td>
        {{#each terms}}
        <td>
            <em class="tx">{{#index_ofWithKey ../max this "odd"}}{{/index_ofWithKey}}번</em>
            <em class="tx">{{#index_ofWithKeyPerSadari ../max this "odd"}}{{/index_ofWithKeyPerSadari}}%</em>
        </td>
        {{/each}}
    </tr>
    <tr>
        <td><div class="sp-even">짝</div></td>
        {{#each terms}}
        <td>
            <em class="tx">{{#index_ofWithKey ../max this "even"}}{{/index_ofWithKey}}번</em>
            <em class="tx">{{#index_ofWithKeyPerSadari ../max this "even"}}{{/index_ofWithKeyPerSadari}}%</em>
        </td>
        {{/each}}
    </tr>
    {{/ifEquals}}
    {{#ifEquals this.type "left_right"}}
    <tr>
        <td><div class="sp-odd">좌</div></td>
        {{#each terms}}
        <td>
            <em class="tx">{{#index_ofWithKey ../max this "LEFT"}}{{/index_ofWithKey}}번</em>
            <em class="tx">{{#index_ofWithKeyPerSadari ../max this "LEFT"}}{{/index_ofWithKeyPerSadari}}%</em>
        </td>
        {{/each}}
    </tr>
    <tr>
        <td><div class="sp-even">우</div></td>
        {{#each terms}}
        <td>
            <em class="tx">{{#index_ofWithKey ../max this "RIGHT"}}{{/index_ofWithKey}}번</em>
            <em class="tx">{{#index_ofWithKeyPerSadari ../max this "RIGHT"}}{{/index_ofWithKeyPerSadari}}%</em>
        </td>
        {{/each}}
    </tr>
    {{/ifEquals}}
    {{#ifEquals this.type "three_four"}}
    <tr>
        <td><div class="sp-odd">3</div></td>
        {{#each terms}}
        <td>
            <em class="tx">{{#index_ofWithKey ../max this "_3"}}{{/index_ofWithKey}}번</em>
            <em class="tx">{{#index_ofWithKeyPerSadari ../max this "_3"}}{{/index_ofWithKeyPerSadari}}%</em>
        </td>
        {{/each}}
    </tr>
    <tr>
        <td><div class="sp-even">4</div></td>
        {{#each terms}}
        <td>
            <em class="tx">{{#index_ofWithKey ../max this "_4"}}{{/index_ofWithKey}}번</em>
            <em class="tx">{{#index_ofWithKeyPerSadari ../max this "_4"}}{{/index_ofWithKeyPerSadari}}%</em>
        </td>
        {{/each}}
    </tr>
    {{/ifEquals}}
    {{#ifEquals this.type "total"}}
    <tr>
        <td><div class="sp-odd">좌4홀</div></td>
        {{#each terms}}
        <td>
            <em class="tx">{{#index_ofWithKey ../max this "LEFT4ODD"}}{{/index_ofWithKey}}번</em>
            <em class="tx">{{#index_ofWithKeyPerSadari ../max this "LEFT4ODD"}}{{/index_ofWithKeyPerSadari}}%</em>
        </td>
        {{/each}}
    </tr>
    <tr>
        <td><div class="sp-even">좌3짝</div></td>
        {{#each terms}}
        <td>
            <em class="tx">{{#index_ofWithKey ../max this "LEFT3EVEN"}}{{/index_ofWithKey}}번</em>
            <em class="tx">{{#index_ofWithKeyPerSadari ../max this "LEFT3EVEN"}}{{/index_ofWithKeyPerSadari}}%</em>
        </td>
        {{/each}}
    </tr>
    <tr>
        <td><div class="sp-even">우4짝</div></td>
        {{#each terms}}
        <td>
            <em class="tx">{{#index_ofWithKey ../max this "RIGHT4EVEN"}}{{/index_ofWithKey}}번</em>
            <em class="tx">{{#index_ofWithKeyPerSadari ../max this "RIGHT4EVEN"}}{{/index_ofWithKeyPerSadari}}%</em>
        </td>
        {{/each}}
    </tr>
    <tr>
        <td><div class="sp-even">우3홀</div></td>
        {{#each terms}}
        <td>
            <em class="tx">{{#index_ofWithKey ../max this "RIGHT3ODD"}}{{/index_ofWithKey}}번</em>
            <em class="tx">{{#index_ofWithKeyPerSadari ../max this "RIGHT3ODD"}}{{/index_ofWithKeyPerSadari}}%</em>
        </td>
        {{/each}}
    </tr>
    {{/ifEquals}}
    {{#ifEquals this.type "left_right"}}{{/ifEquals}}
    {{#ifEquals this.type "left_right"}}{{/ifEquals}}
    {{#ifEquals this.type "left_right"}}{{/ifEquals}}
</script>

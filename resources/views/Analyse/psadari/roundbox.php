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
    <tr>
        <td><div class="sp-odd">홀</div></td>
        {{#each terms}}
        <td>
            <em class="tx">{{#index_ofWithKey ../max this 1}}{{/index_ofWithKey}}번</em>
            <em class="tx">{{#index_ofWithKeyPer ../max this 1}}{{/index_ofWithKeyPer}}%</em>
        </td>
        {{/each}}
    </tr>
    <tr>
        <td><div class="sp-even">짝</div></td>
        {{#each terms}}
        <td>
            <em class="tx">{{#index_ofWithKey ../max this 0}}{{/index_ofWithKey}}번</em>
            <em class="tx">{{#index_ofWithKeyPer ../max this 0}}{{/index_ofWithKeyPer}}%</em>
        </td>
        {{/each}}
    </tr>
</script>

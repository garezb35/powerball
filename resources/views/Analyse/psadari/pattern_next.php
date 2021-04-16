<script class="pattern-item" type="text/x-handlebars-template">
{{#each this}}
<tr>
    <td class="date border-right-none border-top-none border-left-none align-middle text-center" width="90px">{{this.date}}</td>
    <td class="border-top-none">
        <table>
            <tbody>
            <tr>
                {{#each this.current}}
                <td width="10" class="border-none">
                    <table>
                        <tbody>
                        <tr>
                            <td class="patternRound border-none">{{#subRoundUntilThr this.day_round}}{{/subRoundUntilThr}}</td>
                        </tr>
                        <tr>
                            <td class="patternImg border-none"><div class="{{#oddClass this ../this.type}}{{/oddClass}}">{{#oddClassAlias this ../this.type}}{{/oddClassAlias}}</div></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                {{/each}}
            </tr>
            </tbody>
        </table>
    </td>
    <td class="nextResult">
        <table width="100%">
            <tbody>
            <tr>
                <td class="patternRound border-none">{{#subRoundUntilThr this.next.day_round}}{{/subRoundUntilThr}}</td>
            </tr>
            <tr>
                <td class="patternImg border-none"><div class="{{#oddClass this.next this.type}}{{/oddClass}}">{{#oddClassAlias this.next this.type}}{{/oddClassAlias}}</div></td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>
{{/each}}
</script>

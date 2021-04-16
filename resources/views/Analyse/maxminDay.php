<script id="minmaxday-data" type="text/x-handlebars-template">
    {{#each this}}
    <tr>
        <td class="thirdTitle" height="70" rowspan="3" align="center"><span class="date">{{this.date}}</span></td>
        <td height="45" align="center">
            <div class="{{#bigSmall this.poe.count 1 1}}evenText0{{/bigSmall}}">{{#index_of this.poe.count 1}}{{/index_of}}</div>

        </td>
        <td align="center">
            <div class="{{#bigSmall this.poe.count 0 1}}evenText0{{/bigSmall}}">{{#index_of this.poe.count 0}}{{/index_of}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmall this.puo.count 1 1}}evenText0{{/bigSmall}}">{{#index_of this.puo.count 1}}{{/index_of}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmall this.puo.count 0 1}}evenText1{{/bigSmall}}">{{#index_of this.puo.count 0}}{{/index_of}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmall this.noe.count 1 1}}evenText0{{/bigSmall}}">{{#index_of this.noe.count 1}}{{/index_of}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmall this.noe.count 0 1}}evenText1{{/bigSmall}}">{{#index_of this.noe.count 0}}{{/index_of}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmall this.nuo.count 1 1}}evenText1{{/bigSmall}}">{{#index_of this.nuo.count 1}}{{/index_of}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmall this.nuo.count 0 1}}evenText0{{/bigSmall}}">{{#index_of this.nuo.count 0}}{{/index_of}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmall this.nsize.count 3 2}}evenText1{{/bigSmall}}">{{#index_of this.nsize.count 3}}{{/index_of}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmall this.nsize.count 2 2}}evenText0{{/bigSmall}}">{{#index_of this.nsize.count 2}}{{/index_of}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmall this.nsize.count 1 2}}evenText1{{/bigSmall}}">{{#index_of this.nsize.count 1}}{{/index_of}}</div>
        </td>
    </tr>
    <tr>
        <td height="45" align="center">
            <span class="">{{#perOfDayFromArray this.poe.count 1}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.poe.count 0}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.puo.count 1}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.puo.count 0}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.noe.count 1}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.noe.count 0}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.nuo.count 1}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.nuo.count 0}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.nsize.count 3}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.nsize.count 2}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.nsize.count 1}}{{/perOfDayFromArray}}%</span>
        </td>
    </tr>
    <tr>
        <td height="45" align="center"><span class="">{{#index_of this.poe.max 1}}{{/index_of}}</span>연속</td>
        <td align="center"><span class="">{{#index_of this.poe.max 0}}{{/index_of}}</span>연속</td>
        <td align="center"><span class="">{{#index_of this.puo.max 1}}{{/index_of}}</span>연속</td>
        <td align="center"><span class="">{{#index_of this.puo.max 0}}{{/index_of}}</span>연속</td>
        <td align="center"><span class="">{{#index_of this.noe.max 1}}{{/index_of}}</span>연속</td>
        <td align="center"><span class="">{{#index_of this.noe.max 0}}{{/index_of}}</span>연속</td>
        <td align="center"><span class="">{{#index_of this.nuo.max 1}}{{/index_of}}</span>연속</td>
        <td align="center"><span class="">{{#index_of this.nuo.max 0}}{{/index_of}}</span>연속</td>
        <td align="center"><span class="">{{#index_of this.nsize.max 3}}{{/index_of}}</span>연속</td>
        <td align="center"><span class="">{{#index_of this.nsize.max 2}}{{/index_of}}</span>연속</td>
        <td align="center"><span class="">{{#index_of this.nsize.max 1}}{{/index_of}}</span>연속</td>
    </tr>
    {{/each}}
</script>

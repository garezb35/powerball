<script id="minmaxday-data" type="text/x-handlebars-template">
    {{#each this}}
    <tr>
        <td height="70" rowspan="3" align="center" class="thirdTitle"><span class="date">{{this.date}}</span></td>
        <td height="45" align="center">
            <div class="{{#bigSmallSadari this.lr.count 'LEFT' 'left_right'}}evenText0{{/bigSmallSadari}}">{{this.lr.count.LEFT}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmallSadari this.lr.count 'RIGHT' 'left_right'}}evenText1{{/bigSmallSadari}}">{{this.lr.count.RIGHT}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmallSadari this.tf.count '_3' 'three_four'}}evenText0{{/bigSmallSadari}}">{{this.tf.count._3}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmallSadari this.tf.count '_4' 'three_four'}}evenText1{{/bigSmallSadari}}">{{this.tf.count._4}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmallSadari this.oe.count 'odd' 'odd_even'}}evenText0{{/bigSmallSadari}}">{{this.oe.count.odd}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmallSadari this.oe.count 'even' 'odd_even'}}evenText1{{/bigSmallSadari}}">{{this.oe.count.even}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmallSadari this.total.count 'LEFT4ODD' 'total_lines'}}evenText0{{/bigSmallSadari}}">{{this.total.count.LEFT4ODD}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmallSadari this.total.count 'RIGHT3ODD' 'total_lines'}}evenText1{{/bigSmallSadari}}">{{this.total.count.RIGHT3ODD}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmallSadari this.total.count 'LEFT3EVEN' 'total_lines'}}evenText0{{/bigSmallSadari}}">{{this.total.count.LEFT3EVEN}}</div>
        </td>
        <td align="center">
            <div class="{{#bigSmallSadari this.total.count 'RIGHT4EVEN' 'total_lines'}}evenText1{{/bigSmallSadari}}">{{this.total.count.RIGHT4EVEN}}</div>
        </td>
    </tr>
    <tr>
        <td height="45" align="center">
            <span class="">{{#perOfDayFromArray this.lr.count 'LEFT'}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.lr.count 'RIGHT'}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.tf.count '_3'}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.tf.count '_4'}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.oe.count 'odd'}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.oe.count 'even'}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.total.count 'LEFT4ODD'}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.total.count 'RIGHT3ODD'}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.total.count 'LEFT3EVEN'}}{{/perOfDayFromArray}}%</span>
        </td>
        <td align="center">
            <span class="">{{#perOfDayFromArray this.total.count 'RIGHT4EVEN'}}{{/perOfDayFromArray}}%</span>
        </td>
    </tr>
    <tr>
        <td height="45" align="center"><span class="">{{this.lr.max.LEFT}}</span>연속</td>
        <td align="center"><span class="">{{this.lr.max.RIGHT}}</span>연속</td>
        <td align="center"><span class="">{{this.tf.max._3}}</span>연속</td>
        <td align="center"><span class="">{{this.tf.max._4}}</span>연속</td>
        <td align="center"><span class="">{{this.oe.max.odd}}</span>연속</td>
        <td align="center"><span class="">{{this.oe.max.even}}</span>연속</td>
        <td align="center"><span class="">{{this.total.max.LEFT4ODD}}</span>연속</td>
        <td align="center"><span class="">{{this.total.max.RIGHT3ODD}}</span>연속</td>
        <td align="center"><span class="">{{this.total.max.LEFT3EVEN}}</span>연속</td>
        <td align="center"><span class="">{{this.total.max.RIGHT4EVEN}}</span>연속</td>
    </tr>
    {{/each}}
</script>

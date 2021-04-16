<script id="chart-data" type="text/x-handlebars-template">
    <tr>
        <td class="p-0">
            <div class="bar_graph">
                <dl class="mb-0 border-bottom-0 border-top-0" style="margin-top: 30px">
                    <dd>
                        <div class="bar">
                            <p class="left {{#bigSmallSadari this.left_right.count "LEFT" "left_right"}}on{{/bigSmallSadari}}" style="width:{{#returnPerSadari this.left_right.count "LEFT"}}{{/returnPerSadari}}%;">
                                <span class="per"><strong>{{left_right.count.LEFT}}</strong> ({{#returnPerSadari this.left_right.count "LEFT"}}{{/returnPerSadari}}%)</span>
                                <span class="tx">좌</span>
                            </p>
                            <p class="right {{#bigSmallSadari this.left_right.count "RIGHT" "left_right"}}on{{/bigSmallSadari}}" style="width:{{#returnPerSadari this.left_right.count "RIGHT"}}{{/returnPerSadari}}%;">
                                <span class="per"><strong>{{left_right.count.RIGHT}}</strong> ({{#returnPerSadari this.left_right.count "RIGHT"}}{{/returnPerSadari}}%)</span>
                                <span class="tx">우</span>
                            </p>
                        </div>
                    </dd>
                    <dd>
                        <div class="bar">
                            <p class="left {{#bigSmallSadari this.three_four.count "_3" "three_four"}}on{{/bigSmallSadari}}" style="width:{{#returnPerSadari this.three_four.count "_3"}}{{/returnPerSadari}}%;">
                            <span class="per"><strong>{{three_four.count._3}}</strong> ({{#returnPerSadari this.three_four.count "_3"}}{{/returnPerSadari}}%)</span>
                            <span class="tx">3</span>
                            </p>
                            <p class="right {{#bigSmallSadari this.three_four.count "_4" "three_four"}}on{{/bigSmallSadari}}" style="width:{{#returnPerSadari this.three_four.count "_4"}}{{/returnPerSadari}}%;">
                            <span class="per"><strong>{{three_four.count._4}}</strong> ({{#returnPerSadari this.three_four.count "_4"}}{{/returnPerSadari}}%)</span>
                            <span class="tx">4</span>
                            </p>
                        </div>
                    </dd>
                    <dd>
                        <div class="bar">
                            <p class="left {{#bigSmallSadari this.odd_even.count "odd" "odd_even"}}on{{/bigSmallSadari}}" style="width:{{#returnPerSadari this.odd_even.count "odd"}}{{/returnPerSadari}}%;">
                            <span class="per"><strong>{{odd_even.count.odd}}</strong> ({{#returnPerSadari this.odd_even.count "odd"}}{{/returnPerSadari}}%)</span>
                            <span class="tx">홀</span>
                            </p>
                            <p class="right {{#bigSmallSadari this.odd_even.count "even" "odd_even"}}on{{/bigSmallSadari}}" style="width:{{#returnPerSadari this.odd_even.count "even"}}{{/returnPerSadari}}%;">
                            <span class="per"><strong>{{odd_even.count.even}}</strong> ({{#returnPerSadari this.odd_even.count "even"}}{{/returnPerSadari}}%)</span>
                            <span class="tx">짝</span>
                            </p>
                        </div>
                    </dd>
                </dl>
            </div>
        </td>
        <td class="position-relative">
            <div id="canvas-holder" style="width: 350px;position: absolute;top: -1px;left: -70px;" class="position-absolute">
                <canvas id="chart-area"></canvas>
            </div>
            <ul class="infos" style="top: -90px;">
                <li class="left4 {{#bigSmallSadari this.total_lines.count "LEFT4ODD" "total_lines"}}on{{/bigSmallSadari}}"><span class="ic"></span>좌4홀 : {{this.total_lines.count.LEFT4ODD}}회 ({{#returnPerSadari this.total_lines.count "LEFT4ODD"}}{{/returnPerSadari}}%) {{#ifEquals this.total_lines.max.LEFT4ODD -1}}{{else}}{{this.total_lines.max.LEFT4ODD}}연속{{/ifEquals}}</li>
                <li class="right3 {{#bigSmallSadari this.total_lines.count "RIGHT3ODD" "total_lines"}}on{{/bigSmallSadari}}"><span class="ic"></span>우3홀 : {{this.total_lines.count.RIGHT3ODD}}회 ({{#returnPerSadari this.total_lines.count "RIGHT3ODD"}}{{/returnPerSadari}}%) {{#ifEquals this.total_lines.max.RIGHT3ODD -1}}{{else}}{{this.total_lines.max.RIGHT3ODD}}연속{{/ifEquals}}</li>
                <li class="left3 {{#bigSmallSadari this.total_lines.count "LEFT3EVEN" "total_lines"}}on{{/bigSmallSadari}}"><span class="ic"></span>좌3짝 : {{this.total_lines.count.LEFT3EVEN}}회 ({{#returnPerSadari this.total_lines.count "LEFT3EVEN"}}{{/returnPerSadari}}%) {{#ifEquals this.total_lines.max.LEFT3EVEN -1}}{{else}}{{this.total_lines.max.LEFT3EVEN}}연속{{/ifEquals}}</li>
                <li class="right4 {{#bigSmallSadari this.total_lines.count "RIGHT4EVEN" "total_lines"}}on{{/bigSmallSadari}}"><span class="ic"></span>우4짝 : {{this.total_lines.count.RIGHT4EVEN}}회 ({{#returnPerSadari this.total_lines.count "RIGHT4EVEN"}}{{/returnPerSadari}}%) {{#ifEquals this.total_lines.max.RIGHT4EVEN -1}}{{else}}{{this.total_lines.max.RIGHT4EVEN}}연속{{/ifEquals}}</li>
            </ul>
        </td>
    </tr>
</script>

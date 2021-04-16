<script id="chart-data" type="text/x-handlebars-template">
    <tr>
        <td class="p-0">
            <div class="bar_graph">
                <dl>
                    <dt>파워볼</dt>
                    <dd>
                        <div class="bar">
                            <p class="left {{#bigSmall this.poe.count 1 1}}on{{/bigSmall}}" style="width:{{#returnPer this.poe.count 1}}{{/returnPer}}%;">
                                <span class="per"><strong>{{#index_of poe.count 1}}{{/index_of}}</strong> ({{#returnPer this.poe.count 1}}{{/returnPer}}%)</span>
                                <span class="tx">홀</span>
                            </p>
                            <p class="right {{#bigSmall this.poe.count 0 1}}on{{/bigSmall}}" style="width:{{#returnPer this.poe.count 0}}{{/returnPer}}%;">
                                <span class="per"><strong>{{#index_of poe.count 0}}{{/index_of}}</strong> ({{#returnPer this.poe.count 0}}{{/returnPer}}%)</span>
                                <span class="tx">짝</span>
                            </p>
                        </div>
                        <div class="bar">
                            <p class="left {{#bigSmall this.puo.count 1 1}}on{{/bigSmall}}" style="width:{{#returnPer this.puo.count 1}}{{/returnPer}}%;">
                                <span class="per"><strong>{{#index_of puo.count 1}}{{/index_of}}</strong> ({{#returnPer this.puo.count 1}}{{/returnPer}})</span>
                                <span class="tx">언더</span>
                            </p>
                            <p class="right {{#bigSmall this.puo.count 0 1}}on{{/bigSmall}}" style="width:{{#returnPer this.puo.count 0}}{{/returnPer}}%;">
                                <span class="per"><strong>{{#index_of puo.count 0}}{{/index_of}}</strong> ({{#returnPer this.puo.count 0}}{{/returnPer}}%)</span>
                                <span class="tx">오버</span>
                            </p>
                        </div>
                    </dd>
                </dl>
                <dl>
                    <dt>일반볼</dt>
                    <dd>
                        <div class="bar">
                            <p class="left {{#bigSmall this.noe.count 1 1}}on{{/bigSmall}}" style="width:{{#returnPer this.noe.count 1}}{{/returnPer}}%;">
                                <span class="per"><strong>{{#index_of noe.count 1}}{{/index_of}}</strong> ({{#returnPer this.noe.count 1}}{{/returnPer}})</span>
                                <span class="tx">홀</span>
                            </p>
                            <p class="right {{#bigSmall this.noe.count 0 1}}on{{/bigSmall}}" style="width:{{#returnPer this.noe.count 0}}{{/returnPer}}%;">
                                <span class="per"><strong>{{#index_of noe.count 0}}{{/index_of}}</strong> ({{#returnPer this.noe.count 0}}{{/returnPer}}%)</span>
                                <span class="tx">짝</span>
                            </p>
                        </div>
                        <div class="bar">
                            <p class="left {{#bigSmall this.nuo.count 1 1}}on{{/bigSmall}}" style="width:{{#returnPer this.nuo.count 1}}{{/returnPer}}%;">
                                <span class="per"><strong>{{#index_of nuo.count 1}}{{/index_of}}</strong> ({{#returnPer this.nuo.count 1}}{{/returnPer}}%)</span>
                                <span class="tx">언더</span>
                            </p>
                            <p class="right {{#bigSmall this.nuo.count 0 1}}on{{/bigSmall}}" style="width:{{#returnPer this.nuo.count 0}}{{/returnPer}}%;">
                                <span class="per"><strong>{{#index_of nuo.count 0}}{{/index_of}}</strong> ({{#returnPer this.nuo.count 0}}{{/returnPer}}%)</span>
                                <span class="tx">오버</span>
                            </p>
                        </div>
                    </dd>
                </dl>
            </div>
        </td>
        <td class="position-relative">
            <div id="canvas-holder" style="width: 400px;position: absolute;top: 61px;left: -100px;" class="position-absolute">
                <canvas id="chart-area"></canvas>
            </div>
            <ul class="infos">
                <li class="big {{#bigSmall this.nsize.count 3 2}}on{{/bigSmall}}"><span class="ic"></span>대 : {{#index_of nsize.count 3}}{{/index_of}}회 ({{#returnPer this.nsize.count 3}}{{/returnPer}}%) {{#ifEquals nsize.max.[3] -1}}{{else}}{{#index_of nsize.max 3}}{{/index_of}}연속{{/ifEquals}}</li>
                <li class="middle {{#bigSmall this.nsize.count 2 2}}on{{/bigSmall}}"><span class="ic"></span>중 : {{#index_of nsize.count 2}}{{/index_of}}회 ({{#returnPer this.nsize.count 2}}{{/returnPer}}%) {{#ifEquals nsize.max.[3] -1}}{{else}}{{#index_of nsize.max 2}}{{/index_of}}연속{{/ifEquals}}</li>
                <li class="small {{#bigSmall this.nsize.count 1 2}}on{{/bigSmall}}"><span class="ic"></span>소 : {{#index_of nsize.count 1}}{{/index_of}}회 ({{#returnPer this.nsize.count 1}}{{/returnPer}}%) {{#ifEquals nsize.max.[3] -1}}{{else}}{{#index_of nsize.max 1}}{{/index_of}}연속{{/ifEquals}}</li>
            </ul>
        </td>
    </tr>
</script>

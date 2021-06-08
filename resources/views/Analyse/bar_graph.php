<script id="bar-info" type="text/x-handlebars-template">
  <div class="bar_graph">
    <dl class="border-top-none">
        <dt>파워볼</dt>
        <dd>
            <div class="bar">
                <p class="left {{#compareBig pb_oe.[1] pb_oe.[0]}}on{{/compareBig}}" style="width:{{#percentageofTwo this.pb_oe 1}}{{/percentageofTwo}}%;">
                    <span class="per"><strong>{{pb_oe.[1]}}</strong> ({{#percentageofTwo this.pb_oe 1}}{{/percentageofTwo}}%)</span>
                    <span class="tx">홀</span>
                </p>
                <p class="right {{#compareBig pb_oe.[0] pb_oe.[1]}}on{{/compareBig}}" style="width:{{#percentageofTwo this.pb_oe 0}}{{/percentageofTwo}}%;">
                    <span class="per"><strong>{{pb_oe.[0]}}</strong> ({{#percentageofTwo this.pb_oe 0}}{{/percentageofTwo}}%)</span>
                    <span class="tx">짝</span>
                </p>
            </div>
            <div class="bar">
                <p class="left {{#compareBig pb_uo.[1] pb_uo.[0]}}on{{/compareBig}}" style="width:{{#percentageofTwo this.pb_uo 1}}{{/percentageofTwo}}%;">
                    <span class="per"><strong>{{pb_uo.[1]}}</strong> ({{#percentageofTwo this.pb_uo 1}}{{/percentageofTwo}}%)</span>
                    <span class="tx">언더</span>
                </p>
                <p class="right {{#compareBig pb_uo.[0] pb_uo.[1]}}on{{/compareBig}}" style="width:{{#percentageofTwo this.pb_uo 0}}{{/percentageofTwo}}%;">
                    <span class="per"><strong>{{pb_uo.[0]}}</strong> ({{#percentageofTwo this.pb_uo 0}}{{/percentageofTwo}}%)</span>
                    <span class="tx">오버</span>
                </p>
            </div>
        </dd>
    </dl>
  </div>
  <div class="bar_graph">
    <dl class="border-top-none">
        <dt>일반볼</dt>
        <dd>
            <div class="bar">
                <p class="left {{#compareBig nb_oe.[1] nb_oe.[0]}}on{{/compareBig}}" style="width:{{#percentageofTwo this.nb_oe 1}}{{/percentageofTwo}}%;">
                    <span class="per"><strong>{{nb_oe.[1]}}</strong> ({{#percentageofTwo this.nb_oe 0}}{{/percentageofTwo}}%)</span>
                    <span class="tx">홀</span>
                </p>
                <p class="right {{#compareBig nb_oe.[0] nb_oe.[1]}}on{{/compareBig}}" style="width:{{#percentageofTwo this.nb_oe 0}}{{/percentageofTwo}}%;">
                    <span class="per"><strong>{{nb_oe.[0]}}</strong> ({{#percentageofTwo this.nb_oe 0}}{{/percentageofTwo}}%)</span>
                    <span class="tx">짝</span>
                </p>
            </div>
            <div class="bar">
                <p class="left {{#compareBig nb_uo.[1] nb_uo.[0]}}on{{/compareBig}}" style="width:{{#percentageofTwo this.nb_uo 1}}{{/percentageofTwo}}%;">
                    <span class="per"><strong>{{nb_uo.[1]}}</strong> ({{#percentageofTwo this.nb_uo 1}}{{/percentageofTwo}}%)</span>
                    <span class="tx">언더</span>
                </p>
                <p class="right {{#compareBig nb_uo.[0] nb_uo.[1]}}on{{/compareBig}}" style="width:{{#percentageofTwo this.nb_uo 0}}{{/percentageofTwo}}%;">
                    <span class="per"><strong>{{nb_uo.[0]}}</strong> ({{#percentageofTwo this.nb_uo 0}}{{/percentageofTwo}}%)</span>
                    <span class="tx">오버</span>
                </p>
            </div>
        </dd>
    </dl>
  </div>
</script>

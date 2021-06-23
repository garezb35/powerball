<script id="users" type="text/x-handlebars-template">
    {{#each this}}
    {{#ifSimilar this.id 'null-'}}
    <li id="{{this.id}}">
        <img src="/assets/images/powerball/class/M1.gif" width="30" height="30">
        <a href="#" onclick="return false;" title="{{this.nickname}}" rel="{{this.id}}" class="uname">{{#substring this.id}}{{/substring}}...훈령병</a>
        <span style="position:absolute;right:10px;font-weight:normal;font-size:11px;color:#a29c9b;">{{#displayKTime this.time}}{{/displayKTime}}전</span>
    </li>
    {{else}}
    <li id="{{this.id}}">
        <img src="{{#loadLevelImage this.level}}{{/loadLevelImage}}" width="30" height="30">
        <a href="#" onclick="return false;" title="{{this.nickname}}" rel="{{this.id}}" class="uname">{{this.nickname}}</a>
        <span style="position:absolute;right:10px;font-weight:normal;font-size:11px;color:#a29c9b;">{{#displayKTime this.time}}{{/displayKTime}}전</span>
    </li>
    {{/ifSimilar}}

    {{/each}}
</script>

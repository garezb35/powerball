<script id="users" type="text/x-handlebars-template">
    {{#each this}}
    {{#ifEquals this.id 'NULL'}}
    {{else}}
    <li id="{{this.id}}">
        <img src="{{#loadLevelImage this.level}}{{/loadLevelImage}}" width="23" height="23">
        <a href="#" onclick="return false;" title="{{this.nickname}}" rel="{{this.id}}" class="uname">{{this.nickname}}</a>
        <span style="position:absolute;right:10px;font-weight:normal;font-size:11px;color:#a29c9b;">{{#displayKTime this.time}}{{/displayKTime}}전</span>
    </li>
    {{/ifEquals}}

    {{/each}}
</script>

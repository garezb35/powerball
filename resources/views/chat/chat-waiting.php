<script id="connected_list" type="text/x-handlebars-template">
    {{#each this}}
    <li id="u-{{this.id}}">
        <img src="{{this.image}}" class="profile" />
        <img src="{{#loadLevelImage this.level}}{{/loadLevelImage}}" width="30" height="30" />
        <a href="#" onclick="return false;" title="{{this.nickname}}" rel="{{this.id}}" class="uname">{{this.nickname}}</a>

        {{#ifEquals this.today ""}}
        {{else}}
        <div class="todayMsg">
            <div class="inn">
                <p>
                    <span>{{this.today}}</span>
                </p>
            </div>
        </div>
        {{/ifEquals}}
    </li>
    {{/each}}
</script>

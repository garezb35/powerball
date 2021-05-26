<script id="pickster-list" type="text/x-handlebars-template">
    {{#each this}}
    <li class="rank{{order}}">
        <span class="rank">{{order}}위</span>
        <span class="profile">
           <img src="{{user.image}}" class="profileImg" />
        </span>
        <span class="level">
            <img src="{{user.get_level.value3}}" />
        </span>
        <strong>{{user.nickname}}</strong>
        {{#compareBig old_order 0}}
        <span class="rankType"><i class="fa fa-caret-down" ></i></span>
        <span class="rankTypeNum down">{{old_order}}</span>
        {{else}}
        {{#ifEquals old_order "0"}}
        <span class="rankTypeNum none">-</span>
        {{else}}
        <span class="rankType"><i class="fa fa-caret-up" ></i></span>
        <span class="rankTypeNum up">{{#removeMinus old_order}}{{/removeMinus}}</span>
        {{/ifEquals}}
        {{/compareBig}}
    </li>
    {{/each}}
</script>

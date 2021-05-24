<script id="chat-item" type="text/x-handlebars-template">
    {{#each this}}
    <li class="bgYellow">
        <div class="thumb red" rel="{{this.roomIdx}}">
            <img src="{{#displayImg this.roomandpicture 1}}{{/displayImg}}" class="roomImg">
            {{#checkCurWin this.winning_history}}{{/checkCurWin}}
        </div>
        <div class="title">
            <span class="win"><span>{{#wl this.winning_history "w"}}{{/wl}}</span>승</span> <span class="lose"><span>{{#wl this.winning_history "l"}}{{/wl}}</span>패</span> <span class="bar">|</span>
            <a href="#" class="tit" rel="{{this.roomIdx}}" title="{{this.room_connect}}" onclick="return false;">{{this.room_connect}}</a>
            <span class="date">{{#displayKTime this.created_at 2}}{{/displayKTime}}전</span>
        </div>
        <div class="sub">
            <span class="b">{{this.members}}</span> / <span>{{this.max_connect}}</span>
            <span class="opener">
                <img src="{{#displayImg this.roomandpicture 2}}{{/displayImg}}" width="30" height="30">
                <a href="#" onclick="return false;" title="{{this.roomandpicture.nickname}}" rel="{{this.roomandpicture.userIdKey}}" class="uname">{{this.roomandpicture.nickname}}</a>
             </span>
        </div>
        {{{checkSeqWin this}}}
    </li>
    {{/each}}
</script>

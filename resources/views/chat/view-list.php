<script id="view-list" type="text/x-handlebars-template">
    <li id="u-{{this.id}}">
        <img src="{{#ifEquals this.image ""}}https://www.powerballgame.co.kr/images/profile.png{{else}}{{this.image}}{{/ifEquals}}" class="profile" />
        {{#ifEquals this.userType 1}}
        <span class="icon_opener">방장</span>
        {{/ifEquals}}
        {{#ifEquals this.userType 2}}
        <span class="icon_manager">매니저</span>
        {{/ifEquals}}
        {{#ifEquals this.userType 3}}
        <span class="icon_managerFixMember">매니저</span>{{/ifEquals}}
        {{#ifEquals this.userType 4}}
        <span class="icon_fixMember">고정</span>
        {{/ifEquals}}
        <img src="{{#loadLevelImage this.level}}{{/loadLevelImage}}" width="30" height="30" />
        <a href="#" onclick="return false;" title="{{this.name}}" rel="{{this.id}}" class="uname">{{this.name}}</a>
        {{#ifEquals this.today_word ""}}
        {{else}}
        <div class="todayMsg">
            <div class="inn">
                <p>
                    <span>{{this.today_word}}</span>
                </p>
            </div>
        </div>
        {{/ifEquals}}
    </li>
</script>

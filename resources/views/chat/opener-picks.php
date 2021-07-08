<script id="chat-pick-list" type="text/x-handlebars-template">

    {{#each this.list}}
    <li id="pick-{{this.day_round}}" regdate="{{this.created_date}}">
        <div class="num">
            {{#formatDate this.created_date}}{{/formatDate}}<br>
            {{this.day_round}}회
        </div>
        {{#ifEquals this.nnn -1}}
        <div class="rs ready" style="text-align: center;line-height: 60px">대기</div>
        <div class="blank"></div>
        {{#ifEquals this.betting_data.content ""}}
        {{else}}
        {{{processBettingData this.betting_data.content ../this.list}}}
        {{/ifEquals}}
        {{else}}
        <div class="odd-chat">
            {{#ifEquals this.pb_oe 1}}<div class="chat-pbodd"></div>{{else}}<div class="chat-pbeven"></div>{{/ifEquals}}
            {{#ifEquals this.nb_oe 1}}<div class="chat-nbodd"></div>{{else}}<div class="chat-nbeven"></div>{{/ifEquals}}
            {{#ifEquals this.pb_uo 1}}<div class="chat-pbunder"></div>{{else}}<div class="chat-pbover"></div>{{/ifEquals}}
            {{#ifEquals this.nb_uo 1}}<div class="chat-nbunder"></div>{{else}}<div class="chat-nbover"></div>{{/ifEquals}}
            {{#ifEquals this.nb_size 1}}<div class="chat-nbsmall">소</div>{{/ifEquals}}
            {{#ifEquals this.nb_size 2}}<div class="chat-nbmiddle">중</div>{{/ifEquals}}
            {{#ifEquals this.nb_size 3}}<div class="chat-nbbig">대</div>{{/ifEquals}}
        </div>
        <div class="blank"></div>
        {{#compareBigEqual  this.day_round ../this.round}}
        {{#ifEquals this.betting_data.content ""}}
        <div class="pick nnonn pass" style="text-align:center;line-height: 60px;font-weight: bold;font-size: 14px" oddeven_powerball="n" oddeven_number="n" underover_powerball="o" underover_number="n" period="n">패스</div>
        {{else}}
        {{{processBettingData this.betting_data.content ../this}}}
        {{/ifEquals}}
        {{else}}
        <div class="pickResultText"><div style="width:60px;text-align:center;">개설전</div></div>
        {{/compareBigEqual}}
        {{/ifEquals}}
    </li>
    {{/each}}
</script>

<script id="chat-pick-list-cur" type="text/x-handlebars-template">
    {{#each this.list}}
    <div class="num">
        02월08일<br>
        {{this.day_round}}회
    </div>
    {{#ifEquals this.nnn -1}}
    <div class="rs ready" style="text-align: center;line-height: 60px">대기</div>
    <div class="blank"></div>
    {{#ifEquals this.betting_data.content ""}}
    {{else}}
    {{{processBettingData this.betting_data.content ../this.list}}}
    {{/ifEquals}}
        {{else}}
        <div class="odd-chat">
            {{#ifEquals this.pb_oe 1}}<div class="chat-pbodd"></div>{{else}}<div class="chat-pbeven"></div>{{/ifEquals}}
        {{#ifEquals this.nb_oe 1}}<div class="chat-nbodd"></div>{{else}}<div class="chat-nbeven"></div>{{/ifEquals}}
        {{#ifEquals this.pb_uo 1}}<div class="chat-pbunder"></div>{{else}}<div class="chat-pbover"></div>{{/ifEquals}}
        {{#ifEquals this.nb_uo 1}}<div class="chat-nbunder"></div>{{else}}<div class="chat-nbover"></div>{{/ifEquals}}
        {{#ifEquals this.nb_size 1}}<div class="chat-nbsmall">소</div>{{/ifEquals}}
        {{#ifEquals this.nb_size 2}}<div class="chat-nbmiddle">중</div>{{/ifEquals}}
        {{#ifEquals this.nb_size 3}}<div class="chat-nbbig">대</div>{{/ifEquals}}
            </div>
            <div class="blank"></div>
        {{#ifEquals this.betting_data.content ""}}
            <div class="pick nnonn pass" style="text-align:center;line-height: 60px;font-weight: bold;font-size: 14px" oddeven_powerball="n" oddeven_number="n" underover_powerball="o" underover_number="n" period="n">패스</div>
        {{else}}
        {{{processBettingData this.betting_data.content ../this}}}
        {{/ifEquals}}
        {{/ifEquals}}
    {{/each}}
</script>

<script class="checklist" type="text/x-handlebars-template">
    {{#each this}}
    <li data-code="{{this.code}}">
        <span class="count">{{#inc @index 1}}{{/inc}}</span>
        <div class="img {{this.class}}">{{this.alias}}</div>
        <span class="round">{{this.round}}</span>
    </li>
    {{/each}}
</script>

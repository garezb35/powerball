<script id="winning-date" type="text/x-handlebars-template">
{{#each this.oe as | child childIndex |}}
<tr>
    <td class="text-center" style="width:150px">{{#inc child.winning_id}}{{/inc}}</td>
    <td class="text-center">{{child.ai_id}}</td>
    <td class="text-center">{{child.winning_num}}연승중</td>
    <td class="text-center">{{#index_ofWithPick @root.oe "oe" childIndex }}{{/index_ofWithPick}}</td>
    <td class="text-center">{{#index_ofWithKey @root.uo childIndex "ai_id"}}{{/index_ofWithKey}}</td>
    <td class="text-center">{{#index_ofWithKey @root.uo childIndex "winning_num"}}{{/index_ofWithKey}}연승중</td>
    <td class="text-center">{{#index_ofWithPick @root.uo "uo" childIndex }}{{/index_ofWithPick}}</td>
</tr>
{{/each}}
</script>

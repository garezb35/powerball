<?php $from = empty($from) ? "" : $from ?>
<?php $to = empty($to) ? "" : $to ?>
<?php $limit = empty($limit) ? "" : $limit ?>
<div class ="position-relative pb-0 border-bottom-0">
    <div class="collapse show collapsing-element" id="peod">
        <table class="table table-bordered mb-0" id="patternBox">
          <colgroup>
            <col width="100px"/>
            <col width="100px"/>
            <col width="25%"/>
            <col width="25%"/>
          </colgroup>
            <tbody>
                <tr>
                    <div class="pattern-tr"></div>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<script id="pattern-date" type="text/x-handlebars-template">
  <div class="border-cell">
      <div class="content pattern-t">
    <table class="patternTable table-borderless">
        <tbody>
            <tr>
                {{#each list as |child childIndex|}}
                <td class="border-none p-none">
                    <table class="innerTable">
                        <tbody>
                        <tr>
                            <th class="title_{{child.type}} border-none"><span class="pow-element">{{#ifEquals child.type "under/odd"}}1{{else}}2{{/ifEquals}}</span></th>
                        </tr>
                        {{#each child.list as |pick pickIndex|}}
                        <tr>
                            <td class="border-none"><div class="{{child.type}}">{{pick}}</div></td>
                        </tr>
                        {{/each}}
                        {{#times @root.max child.list.length}}
                        <tr>
                            <td class="border-none">&nbsp;</td>
                        </tr>
                        {{/times}}

                        </tbody>
                    </table>
                </td>
                {{/each}}
            </tr>
        </tbody>
    </table>
  </div>
</div>
</script>


<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>아이템 구입 유저목록</h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <form id="frmSearch">
                <input type="hidden" name="sKind" id="sKind">
                <input type="hidden" name="level" id="level">
                <input type="hidden" name="role" id="role">
                <table class="table table-bordered table-striped">
                   <tr class="thead-dark">
                      <th>닉네임</th>
                      <th>아이템명</th>
                      <th>기간</th>
                      <th class="text-center"></th>
                   </tr>
                   <?php
                      if(!empty($item))
                      {
                          foreach($item as $record)
                          {
                      ?>
                   <tr>
                      <td><?=$record->nickname?></td>
                      <td><?=$record->mname?></td>
                      <td><?=$record->terms1?> | <?=$record->terms2?></td>
                      <td class="text-center">
                         <a class="btn btn-sm btn-danger deletePur" href="#" data-id="<?php echo $record->id; ?>">
                           <i class="fa fa-trash"></i>
                         </a>
                      </td>
                   </tr>
                 <?php }} ?>
                </table>
            </form>
            <div>
                <?php echo $this->pagination->create_links(); ?>
             </div>
         </div>
      </div>
   </section>
</div>

<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>월요일 시상품</h1>

   </section>
   <section class="content">
     <div class="row">
       <div class="col-xs-6 text-right">
         <a href="<?php echo base_url(); ?>addGift" class="btn btn-sm btn-primary">새로 등록</a>
       </div>
     </div>
      <div class="row my-4">
         <div class="col-xs-6">
            <form id="frmSearch">
                <table class="table table-bordered table-striped">
                   <tr class="thead-dark">
                      <th>등급</th>
                      <th>아이템명</th>
                      <th>개수</th>
                      <th class="text-center"></th>
                   </tr>
                   <?php
                      if(!empty($item))
                      {
                          foreach($item as $record)
                          {
                      ?>
                   <tr>
                      <td><?=$record->order ?>위</td>
                      <td><?=$record->mname?></td>
                      <td><?=$record->count?></td>
                      <td class="text-center">
                         <a class="btn btn-sm btn-danger deleteWinGift" href="#" data-id="<?php echo $record->id; ?>">
                           <i class="fa fa-trash"></i>
                         </a>
                      </td>
                   </tr>
                 <?php } } ?>
                </table>
            </form>
            <div>
                <?php //echo $this->pagination->create_links(); ?>
             </div>
         </div>
      </div>
   </section>
</div>


<script>
jQuery(document).on("click", ".deleteWinGift", function(){
  var id = $(this).data("id"),
    hitURL = baseURL + "deleteGift",
    currentRow = $(this);

  var confirmation = confirm("Are you sure to delete this gift ?");

  if(confirmation)
  {
    jQuery.ajax({
    type : "POST",
    dataType : "json",
    url : hitURL,
    data : { id:id }
    }).done(function(data){
      currentRow.parents('tr').remove();
      if(data.status = true) { alertifyByCommon("successfully deleted"); }
      else if(data.status = false) { alertifyByCommon("deletion failed"); }
      else { alertifyByCommon("Access denied..!"); }
    });
  }
});
</script>

<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>블록아이피목록</h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-xs-6">
            <form name="frmList" id="frmList" method="get" action="<?=base_url()?>ipblocked">
               <div class="box-tools">
                  <div class="input-group" style="margin-bottom: 10px">
                     <div class="pull-right">
                        <label style="display:block; ">&nbsp;</label>
                        <input class="btn btn-primary btn-sm" value="검색" type="submit">
                     </div>

                     <div class="pull-right">
                        <label style="display:block; ">아이피주소</label>
                        <input type="text" name="content" class="form-control input-sm" style="width: 150px;"
                           value="<?=empty($_GET['content']) == 0 ? $_GET['content']:"" ?>" >
                     </div>
                    </div>
                  </div>
               </div>
            </form>
            <form id="frmSearch">
                <input type="hidden" name="sKind" id="sKind">
                <input type="hidden" name="level" id="level">
                <input type="hidden" name="role" id="role">
                <table class="table table-bordered table-striped">
                   <tr class="thead-dark">
                      <th>Id</th>
                      <th>아이피주소</th>
                      <th>창조일</th>
                      <th class="text-center"></th>
                   </tr>
                   <?php
                      if(!empty($records))
                      {
                          foreach($records as $record)
                          {
                      ?>
                   <tr>
                      	<td><?=$record->id ?></td>
                      	<td><?=$record->ip?></td>
                      	<td><?=$record->created_at?></td>
	                    <td class="text-center">
	                         <a class="btn btn-sm btn-info restoreIP" href="javascript:void()" data-ip="<?=$record->ip?>">
	                           블록해제
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

<script>
	$(".restoreIP").click(function(){
		var ip = $(this).data("ip");
		var confirmation = confirm("해제하시겠습니까 ?");
		var hitURL = baseURL + "enableIP";
		var currentRow = $(this);
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { ip : ip }
			}).done(function(data){
				if(data.status == true) { alertifyByCommon("처리되었습니다.");currentRow.parents('tr').remove(); }
				else if(data.status == false) { alertifyByCommon("처리 오류."); }
				else { alertifyByCommon("Access denied..!"); }
			}).fail(function(xhr){
				console.log(xhr)
		});
	})
</script>
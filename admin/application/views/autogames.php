<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>파워시물레이션</h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-xs-6">
            <form name="frmList" id="frmList" method="get" action="<?=base_url()?>autogames">
               <div class="box-tools">
                  <div class="input-group" style="margin-bottom: 10px">
                     <div class="pull-right">
                        <label style="display:block; ">&nbsp;</label>
                        <input class="btn btn-primary btn-sm" value="검색" type="submit">
                     </div>
                     <div class="pull-right">
                        <label style="display: block;">갱신일</label>
                        <input type="date" name="end_date" class="form-control input-sm"
                           value="<?=empty($_GET['end_date']) == 0 ? $_GET['end_date']:"" ?>">
                     </div>
                     <div class="pull-right">
                        <label style="display: block;">창조일</label>
                        <input type="date" name="start_date" class="form-control input-sm"
                           value="<?=empty($_GET['start_date']) == 0 ? $_GET['start_date']:"" ?>" >
                     </div> 
                     <div class="pull-right">
                        <label style="display:block; ">닉네임</label>
                        <input type="text" name="nickname" class="form-control input-sm" style="width: 150px;"
                           value="<?=empty($_GET['nickname']) == 0 ? $_GET['nickname']:"" ?>" >
                     </div>
                     <div class="pull-right">
                        <label style="display:block; ">배팅상태</label>
                        <select name="state" id="state" class="form-control input-sm">
                           <option value=""></option>
                           <option value="1" <?=isset($_GET['state']) && $_GET['state']==1 ? "selected":"" ?>>능동</option>
                           <option value="0" <?=isset($_GET['state']) && $_GET['state']==0 ? "selected":"" ?>>비능동</option>
                        </select>
                     </div>
                     <div class="pull-right">
                        <label style="display:block; ">배팅형태</label>
                        <select name="bet_type" id="bet_type" class="form-control input-sm">
                           <option value=""></option>
                           <option value="2" <?=isset($_GET['bet_type']) && $_GET['bet_type']==2 ? "selected":"" ?>>현배팅</option>
                           <option value="1" <?=isset($_GET['bet_type']) && $_GET['bet_type']==1 ? "selected":"" ?>>이전배팅</option>
                        </select>
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
                      <th class="text-center">(상태)아이디</th>
                      <th class="text-center">닉네임</th>
                      <th class="text-center">배팅형태</th>
                      <th class="text-center">시작포인트</th>
                      <th class="text-center">현재포인트</th>
                      <th class="text-center">창조일</th>
                      <th class="text-center">갱신일</th>
                      <th class="text-center"></th>
                   </tr>
                   <?php
                      if(!empty($records))
                      {
                          foreach($records as $record)
                          {
                      ?>
                   <tr>
                      	<td class="align-middle text-center">
                           <a href="javascript:void(0)" data-id="<?=$record->id?>" data-state="<?=$record->state?>" class="btnState">
                           <?php if($record->state == 1): ?>
                           <span class="badge badge-pill badge-primary">&nbsp;</span>   
                           <?php endif; ?>
                           <?php if($record->state == 0): ?>
                           <span class="badge badge-pill badge-secondary">&nbsp;</span>   
                           <?php endif; ?>
                           <?=$record->id ?>
                           </a>
                        </td>
                      	<td  class="align-middle text-center"><?=$record->nickname?></td>
                      	<td  class="align-middle text-center"><?=$record->betting_type == 2 ? "현재회차배팅" : "지난회차배팅"?></td>
                        <td class="align-middle text-center"><?=$record->start_amount?></td>
                        <td class="align-middle text-center"><?=$record->user_amount?></td>
                        <td class="align-middle text-center"><?=$record->created_at?></td>
                        <td class="align-middle text-center"><?=$record->updated_at?></td>
	                    <td class="text-center text-center">
	                         <a class="btn btn-sm btn-danger deleteGame" href="javascript:void()" data-id="<?=$record->id?>">
	                           삭제
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
	$(".btnState").click(function(){
		var id = $(this).data("id");
      var state = $(this).data("state");
		var confirmation = confirm("변경하시겠습니까 ?");
		var hitURL = baseURL + "alterGame";
		var currentRow = $(this);
		if(confirmation){
         jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { id : id ,state : state}
            }).done(function(data){
               if(data.status == true) { 
                  alertifyByCommon("처리되었습니다.");
                  currentRow.find("span").removeClass("badge-primary")
                  currentRow.find("span").removeClass("badge-secondary")
                  currentRow.find("span").addClass(data.class)
                  currentRow.data("state",data.state)
               }
               else if(data.status == false) { alertifyByCommon("처리 오류."); }
               else { alertifyByCommon("Access denied..!"); }
            }).fail(function(xhr){
               console.log(xhr)
         });
      }
	})

   $(".deleteGame").click(function(){
      var id = $(this).data("id");
      var confirmation = confirm("삭제하시겠습니까 ?");
      var hitURL = baseURL + "deleteGame";
      var currentRow = $(this);
      if(confirmation){
         jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { id : id }
            }).done(function(data){
               if(data.status == true) { alertifyByCommon("처리되었습니다.");currentRow.parents('tr').remove(); }
               else if(data.status == false) { alertifyByCommon("처리 오류."); }
               else { alertifyByCommon("Access denied..!"); }
            }).fail(function(xhr){
               console.log(xhr)
         });
      }
   })
</script>

<style type="text/css">
   .badge-primary{
      background-color: #28a745;
   }
   .btnState{
      cursor: pointer;
   }
</style>
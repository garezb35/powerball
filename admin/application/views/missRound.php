<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>오류리스트</h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <form id="frmSearch">
                <table class="table table-bordered table-striped">
                   <tr class="thead-dark">
                      <th>아이디</th>
                      <th>하루회차</th>
                      <th>일시</th>
                      <th class="text-center"></th>
                   </tr>
                   <?php
                      if(!empty($item))
                      {
                          foreach($item as $record)
                          {
                      ?>
                   <tr>
                      <td><?=$record->id ?></td>
                      <td><?=$record->day_round?></td>
                      <td><?=$record->created_at?></td>
                      <td class="text-center">
                         <a class="btn btn-sm btn-info" href="javascript:processRound(<?=$record->day_round?>,'<?=$record->created_at?>')">
                           <i class="fa fa-pencil"></i>
                         </a>
                         <a class="btn btn-sm btn-danger deleteMiss" href="#" data-id="<?php echo $record->id; ?>">
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

<div class="modal fade" id="resultModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">파워볼 결과</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">파워볼 숫자:</label>
            <input type="text" class="form-control" id="pb"/>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">일반볼 숫자(5개):</label>
            <input type="text" class="form-control" id="nb" placeholder="반점으로 구분해주세요"/>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">하루 회차:</label>
            <input type="text" class="form-control" id="round"/>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">라운드:</label>
            <input type="text" class="form-control" id="uniround"/>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">일시:</label>
            <input type="text" class="form-control" id="date" placeholder="<?=date("Y-m-d ")?>"/>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
        <button type="button" class="btn btn-primary" id="btn_add">결과 넣기</button>
      </div>
    </div>
  </div>
</div>

<script>
  var currentRow = null;
  function processRound(day_round,date){
    currentRow = $(this);
    $("#resultModal").modal("show")
  }
  $("#btn_add").click(function(){
    var pb = $('#pb').val();
    var nb = $('#nb').val();
    var round = $('#round').val();
    var date = $('#date').val();
    var uniround = $("#uniround").val()

    jQuery.ajax({
      type : "POST",
      url : "insertMissRound",
      dataType:"json",
      data : { pb : pb,nb:nb,round:round,date:date,uniround:uniround }
    }).done(function(data){
      currentRow.parents('tr').remove();
      var data = parseInt(data)
      if(data == 0){
        alert("입력형식이 정확치 않습니다.")
        return;
      }
      if(data == -1){
        alert("결과값이 있습니다.")
        return;
      }
      $("#resultModal").modal("toggle")
      missed--;
    })
  })

  jQuery(document).on("click", ".deleteMiss", function(){
		var id = $(this).data("id"),
			hitURL = baseURL + "deleteMiss",
			currentRow = $(this);

		var confirmation = confirm("Are you sure to delete this round ?");

		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : id}
			}).done(function(data){
				currentRow.parents('tr').remove();
				if(data.status == 1) { alert(" successfully deleted"); missed--}
				if(data.status != 1) { alert(" deletion failed"); }
			});
		}
	});
</script>

<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>쪽지리스트</h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <form id="frmSearch">
                <table class="table table-bordered table-striped" id="mail_data">
                   <thead>
                     <tr class="thead-dark">
                        <th>번호</th>
                        <th>보낸 사람</th>
                        <th>받는 사람</th>
                        <th>쪽지상태</th>
                        <th>랜덤</th>
                        <th>쪽지보관</th>
                        <th>창조일</th>
                        <th>읽은 시간</th>
                     </tr>
                   </thead>
                </table>
            </form>
         </div>
      </div>
   </section>
</div>
<div class="modal" tabindex="-1" role="dialog" id="mail-dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header"  style="padding-bottom:0px">
        <span class="modal-title">쪽지내용</span>
        <span class="text-danger" style="font-size:11px">
          (<span id="froms"></span>님이 <span id="tos"></span>님에게 쪽지를 전달하었습니다.)
        </span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:5px;">
        <textarea class="mail-content border" readonly style="min-height:170px;width:100%;resize:vertical;"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="btn_protected" data-id=""></button>
        <button type="button" class="btn btn-danger" data-id=""  id="btn_delete">메일삭제</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>
<style>
td,th{
  text-align: center
}
td{
  cursor: pointer
}

</style>
<script>
$(document).ready(function() {
  var mail_dialog = $("#mail-dialog");
  var tr = null;
  $('#mail_data').DataTable( {
      "ajax": "<?=base_url()?>mails"
  } );
  $("body").on("click","td",function(){
    var td = $(this).parent().find("td");
    tr = $(this).parent();
    if(!isNaN(td[0].innerText)){
      jQuery.ajax({
         type : "POST",
         dataType : "json",
         url : baseURL+"contentMail",
         data : { id : td[0].innerText.trim() }
         }).done(function(data){
           if(data.status == true){
              $("#mail-dialog").modal("show");
              $("#froms").text(data.data.fnickname)
              $("#tos").text(data.data.tnickname)
              $(".mail-content").val(data.data.content)
              if(data.data.user_type == "01"){
                $("#btn_protected").removeClass("disabled");
                $("#btn_protected").data("id",data.data.fuserId)
                $("#btn_protected").text(data.data.fnickname + "님 접속차단")
                $("#btn_delete").data("id",data.data.id)
              }
              else{
                $("#btn_protected").addClass("disabled");
                $("#btn_protected").text("")
                $("#btn_protected").data("id",0)
              }
           }
        });
    }
  })

  $("body").on("click","#btn_protected",function(){
    mail_dialog.modal("hide")
    var id = $(this).data("id");
    if(isNaN(id) || id <= 0 ){
      alertify.error("존재하지 않는 유저입니다.")
      mail_dialog.modal("show");
      return false
    }
    currentRow = $(this);
    alertify.prompt( '유저 사이트 이용정지', '정지이유', ''
       , function(evt, value) {
         jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : baseURL + "deleteUser",
            data : { userId : id,reason:value }
            }).done(function(data){
              mail_dialog.modal("show");
              if(data.status == true) { alertify.success("성공적으로 중지되었습니다."); }
              else if(data.status == false) { alertify.error("요청이 실패되었습니다.");  }
              else { alertify.error("접근거절.");  }
        });
        }
       , function() {
         mail_dialog.modal("show");
        });
  })

  $("body").on("click","#btn_delete",function(){
    var id = $(this).data("id")
    if(!isNaN(id) && id > 0 ){
      alertify.confirm('', '삭제하시겠습니까?',
      function()
      {
        jQuery.ajax({
           type : "POST",
           dataType : "json",
           url : baseURL + "deleteMail",
           data : { id : id }
           }).done(function(data){
             mail_dialog.modal("hide");
             if(data.status == true) { alertify.success("삭제되었습니다.");tr.remove() }
             else if(data.status = false) { alertify.error("요청이 실패되었습니다.");  }
             else { alertify.error("접근거절.");  }
       });
      },
      function(){});
    }
  })
});
</script>

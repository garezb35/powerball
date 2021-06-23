<script> var c = 1;</script>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-10">
              <!-- general form elements -->
                <div class="box box-primary">
                   <div class="row border-bottom1">
                       <div class="col-md-2 p-15 backg-grey">
                           <p>제목</p>
                       </div>
                       <div class="col-md-6 p-15">
                           <p><?=$content[0]->title?></p>
                       </div>
                   </div>
                    <div class="row border-bottom1">
                       <div class="col-md-2 p-15 backg-grey">
                           <p>분류</p>
                       </div>
                       <div class="col-md-6 p-15">
                           <p><?=$content[0]->category?></p>
                       </div>
                   </div>
                   <div class="row border-bottom1">
                       <div class="col-md-2 p-15 backg-grey">
                           <p>글쓴이</p>
                       </div>
                       <div class="col-md-4 p-15">
                           <p><?=$content[0]->UserName?></p>
                       </div>
                       <div class="col-md-2 p-15 backg-grey">
                           <p>등록일</p>
                       </div>
                       <div class="col-md-4 p-15">
                           <p><?=$content[0]->updated_at?></p>
                       </div>
                   </div>
                   <div class="row border-bottom1">
                       <div class="col-md-2 p-15 backg-grey">
                           <p>조회</p>
                       </div>
                       <div class="col-md-4 p-15">
                           <p><?=$content[0]->view_count?></p>
                       </div>
                   </div>
                   <div class="row my-4">
                    <div class="col-md-12">
                      <p>
                        <?=str_replace("/assets/upload",base_url_source()."assets/upload",$content[0]->content)?>
                      </p>
                    </div>
                   </div>

                   <div class="row my-4">
                       <div class="col-xs-4 my-3">
                            <a href="/editBoard/<?=$content[0]->id?>?board_type=<?=$this->input->get("board_type")?>" class="btn btn-primary">수정</a>
                            <a href="javascript:deleteBoard(<?=$content[0]->id?>,'<?=$content[0]->type?>')" class="btn btn-danger">삭제</a>
                            <a href="<?=base_url()?>panel?id=<?=$content[0]->type?>" class="btn btn-primary">목록</a>
                       </div>
                   </div>
                     <div class="row">
                         <div class="col-xs-12">
                              <form method="post" name="frmBbs" id="frmBbs">
                                  <input type="hidden" name="postId" value="<?=$content[0]->id?>">
                                  <textarea class="form-control" name="sCONT" id="sCONT"></textarea>
                                  <a href="#" class="btn btn-primary my-4 my-3" onclick="javascript:fnBbsComt('<?=$content[0]->id?>');">댓글달기</a>
                              </form>
                         </div>
                     </div>
                     <div class="row">
                       <div class="col-md-8">
                        <ul class="media-list">
                         <?php if(!empty($comment)): ?>
                         <?php foreach($comment as $value): ?>
                          <li class="media">
                            <div class="media-body">
                                <span class="text-muted pull-right">
                                    <small class="text-muted">
                                      <?=$value->created_at?>
                                    </small>
                                </span>
                                <strong class="text-success"><?=$value->name?></strong>
                                <a href="#" class="text-danger text-bold" onclick="javascript:deleteComment(<?=$value->id?>)">X</a>
                                <p>
                                  <?=$value->content?>
                                </p>
                            </div>
                        </li>
                         <?php endforeach; ?>
                         <?php endif; ?>
                        </ul>
                        <a class="loadmore" href="javascript:loadmore(c,<?=$content[0]->id?>)">Load More</a>
                       </div>
                     </div>
                </div>
            </div>
        </div>
    </section>
</div>
<form id="frmMove">
  <input type="hidden" name="sFL_SEQ">
  <input type="hidden" name="id" value="<?=$content[0]->id?>">
</form>
<style type="text/css">
    .row{
        margin:0;
    }
</style>
<script>
    var comment_count = 0;
    comment_count = <?=$size?>;
    function loadmore(comment_id,id){
      if(comment_id*5 >=comment_count) return;
        jQuery.ajax({
          method: "POST",
          url: baseURL+"getCommentMore",
          data: {id:id,comment_id:comment_id},
          dataType:"json",
          beforeSend:function(){
            $(".loadmore").text("Loading...");
            $(".loadmore").addClass("disabled");
          },
        })
          .done(function( msg ) {
            c++;
            $(".loadmore").text("Load More");
            $(".loadmore").removeClass("disabled");
            if(msg.length > 0){
              for(var i=0;i<msg.length;i++){
                $(".media-list").append("<li class='media'>\
                  <div class='media-body'>\
                    <span class='text-muted pull-right'><small class='text-muted'>\
                    "+msg[i].created_date+"\
                    </small>\
                    </span>\
                    <strong class='text-success'>"+msg[i].name+"</strong>\
                    <p>\
                    "+msg[i].content+"\
                    </p>\
                    </div>\
                    </li>");
              }
            }
          });

    }

    function deleteComment(id){
      var fIptId = "";
      if (!confirm('해당 댓글을 삭제하시겠습니까?')) {
        return;
      }
      var element = $(this);
      jQuery.ajax({
      method: "POST",
      url: baseURL+"deleteComment",
      data: {id:id}
    })
      .done(function( msg ) {
        location.reload();
      });
    }
    function fnBbsComt(id) {
        var frmObj = "#frmBbs";
        var fIptId = "";

        // 내용 체크
        fnIptId    = $(frmObj + " textarea[name='sCONT']");
        if ( !fnIptChk( fnIptId ) ) {
            fnMsgFcs( fnIptId, "내용을 입력하세요." );
            return;
        }
        jQuery.ajax({
          method: "POST",
          url: baseURL+"writeComment",
          data: { sCONT: $("#sCONT").val() , postId: id }
        })
          .done(function( msg ) {
            if(msg > 0){
                window.location.reload();
            }
            else{
                window.alert("오류");
            }
          });
    }
    function deleteBoard(id,type){
      var confirmation = confirm("삭제하시겠습니까?");
      if(confirmation)
      {
        jQuery.ajax({
        type : "POST",
        url : baseURL+"deletePost",
        data : { id : id },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
        }).done(function(data){
          if(data==100) {window.location.href="/panel/?id="+type;}
          if(data==101) alert("실패");
        });
      }
    }

    function fnBbsStatusChange(id) {
      var mode = $("#mode").val();
      jQuery.ajax({
        type : "POST",
        url : baseURL+"updateBoard",
        data : { id : id,mode:mode,ttype : "state" }
        }).done(function(data){
          alert("변경되였습니다.");
        });
    }
    function fnFlDn(sFL_SEQ) {
      var frmObj = "#frmMove";
      $(frmObj + " input[name='sFL_SEQ']").val( sFL_SEQ );
      $(frmObj).attr("method", "post").attr("action", "<?=base_url()?>downloadI").attr("target", "prcFrm");
      $(frmObj).submit();
    }
</script>

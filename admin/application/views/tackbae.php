<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          택배 관리  
      </h1>
    </section>
    <section class="content">
        <form action="./addTackBae" method="post">
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>제목</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="name" class="form-control"  required>
            </div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center">
                  <input type="submit" class="btn btn-primary" value="저장">
                  <input type="reset" class="btn" value="취소">
              </div>
          </div>
        </form>
        <div class="row">
            <div class="col-xs-8">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>제목</th>
                      <th></th>
                    </tr>
                    <?php if(!empty($tackbae)): 
                            foreach($tackbae as $value): ?>
                        <tr>
                          <td><?=$value->name?></td>
                          <td><a href="#" data-id="<?=$value->id?>" class="btn btn-danger btn-sm deleteTack">삭제</a></td>
                        </tr>
                    <?php endforeach;
                        endif; ?>    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
  jQuery(document).on("click", ".deleteTack", function(){
    var id = $(this).data("id"),
      hitURL = baseURL + "deleteTack",
      currentRow = $(this);
    
    var confirmation = confirm("해당 택배사를 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { id : id } 
      }).done(function(data){
        console.log(data);
        currentRow.parents('tr').remove();
        if(data == 1) { alert("성공적으로 삭제되였습니다."); }
        else if(data != 1) { alert("삭제 실패"); }
        else { alert("Access denied..!"); }
      });
    }
  });
</script>
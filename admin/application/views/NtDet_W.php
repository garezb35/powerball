<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/admin.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/neo.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
</head>
<body>
<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> 쪽지쓰기
      </h1>
    </section>
    <section class="content">
      <div class="box box-primary">
          <!-- form start -->
          <form role="form" action="<?php echo base_url() ?>multisend" method="post" id="uproduct" novalidate>
              <div class="box-body" style="padding-right:0px;padding-left:0px">
                  <div class="row">
                      <div class="col-md-12">
                          <label for="receman">받는 사람 :</label>
                          <?php if(empty($_GET['chkMemCode'])): ?>
                          <select class="form-control" name="receman">
                              <option value="0">전체</option>
                          <?php if(!empty($role)): ?>
                          <?php foreach($role as $value): ?>
                              <option value="<?=$value->roleId?>"><?=$value->role?></option>
                          <?php endforeach; ?>
                          <?php endif; ?>
                           </select>
                          <?php endif; ?>
                          <?php if(!empty($_GET['chkMemCode'])): ?>
                              <?=$users?>
                          <?php endif; ?>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 my-4">
                        <textarea class="contentInput" id="wr_content"  name="content" required></textarea>
                    </div>
                  </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                  <input type="submit" class="btn btn-primary" value="저장" />
                  <a  href="javascript:self.close();" class="btn btn-default">닫기</a>
              </div>
          </form>
      </div>
    </section>
</div>
</body>
</html>

<script src="<?php echo base_url(); ?>assets/js/head.js"></script>

<script>

    function fnBbsFileDel(val) {
        var frmObj = document.frmBbs;
        if (!confirm('해당 첨부파일을 삭제하시겠습니까?')) {
            return;
        }
        frmObj.sKind.value = 'D';
        frmObj.sFL_SEQ.value = val;
        frmObj.action = '/admin/bbs_fl_D';
        frmObj.submit();
    }
    $(document).ready(function(){
      $("#uproduct").submit(function(){
        oEditors.getById["wr_content"].exec("UPDATE_CONTENTS_FIELD", []);
      })
    })
</script>
<style>
.contentInput {
    width: 100%;
    height: 250px;
    overflow-y: scroll;
    background-color: #fff;
    overflow: auto;
    resize: none;
}
</style>

<?php $ss= 0;
if($pf==null) $ss = $uc;
if($pf!=null) $ss = $uc-$pf; ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>탈퇴회원</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <form name="frmList" id="frmList" method="get" action="">
                <div class="box-tools">
                  <div class="input-group" style="margin-bottom: 10px">
                    <div class="pull-right">
                      <label style="display:block; ">&nbsp;</label>
                      <input class="btn btn-primary btn-sm" value="검색" type="submit">
                   </div>
                   <div class="pull-right">
                      <label style="display:block; ">내용</label>
                      <input type="text" name="content" class="form-control input-sm" style="width: 150px;"
                       value="<?=empty($_GET['content']) == 0 ? $_GET['content']:"" ?>" >
                   </div>
                   <div class="pull-right">
                      <label style="display:block; ">검색항목</label>
                      <select name="shType" id="shType" class="form-control input-sm">
                        <option value="B" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="B" ? "selected":""?>>회원명</option>
                        <option value="A" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="A" ? "selected":""?>>아이디</option>
                        <option value="D" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="D" ? "selected":""?>>닉네임</option>
                      </select>
                   </div>
                   <div class="pull-right">
                     <label style="display: block;">종료일</label>
                     <input type="date" name="ends_date" class="form-control input-sm"
                     value="<?=empty($_GET['ends_date']) == 0 ? $_GET['ends_date']:"" ?>">
                   </div>
                   <div class="pull-right">
                     <label style="display: block;">시작일</label>
                     <input type="date" name="starts_date" class="form-control input-sm"
                     value="<?=empty($_GET['starts_date']) == 0 ? $_GET['starts_date']:"" ?>" >
                   </div>
                   <div class="pull-right">
                     <label style="display: block;">Page</label>
                     <select name="shPageSize" id="shPageSize" class="form-control input-sm">
                        <?php for($ii = 10 ;$ii<=100;$ii+=5){ ?>
                          <option value="<?=$ii?>" <?=empty($_GET['shPageSize'])==0 && $_GET['shPageSize']==$ii ? "selected":"" ?>><?=$ii?></option>
                        <?php }  ?>
                      </select>
                   </div>
                  </div>
                </div>
              </form>
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <form name="frmSearch" id="frmSearch" method="get">
                    <input type="hidden" name="sKind" id="sKind">
                    <table class="table table-hover table-striped table-bordered">
                      <tr>
                        <th>Id</th>
                        <th>회원명(아이디)</th>
                        <th>닉네임[등급]</th>
                        <th>코인</th>
                        <th>당근</th>
                        <th>핸드폰</th>
                        <th>Email</th>
                        <th>가입일</th>
                        <th class="text-center"></th>
                      </tr>
                      <?php
                      if(!empty($userRecords))
                      {
                          foreach($userRecords as $record)
                          {
                      ?>
                      <tr>
                        <td class="align-middle">
                          <input type="checkbox" name="chkMemCode[]" class="chkMemCode" value="<?=$record->userId ?>">
                          <?=$ss ?></td>
                        <td class="align-middle"><?=$record->name?>(<?=$record->loginId?>)</td>
                        <td class="align-middle"><?=$record->nickname ?>[<?=$record->codename?>]</td>
                        <td class="align-middle"><?=$record->coin?></td>
                        <td class="align-middle"><?=$record->bullet?></td>
                        <td class="align-middle"><?=$record->phoneNumber?></td>
                        <td class="align-middle"><?=$record->email ?></td>
                        <td class="text-center align-middle">
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'editOld/'.$record->userId; ?>?isDeleted=1"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-danger deleteUserSure" href="#" data-userid="<?php echo $record->userId; ?>"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php
                      $ss = $ss-1;
                          }
                      }
                      ?>
                    </table>
                  </form>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
              <a href="javascript:fnMemDel()" class="btn btn-sm btn-danger">삭제</a>
              <a href="javascript:fnMemCnl()" class="btn btn-sm btn-primary">탈퇴취소</a>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
            jQuery("#searchList").submit();
        });
    });
    function fnMemDel(){
      var frmObj = "#frmSearch";
      if (fnSelBoxCnt($(frmObj + " input[class='chkMemCode']")) <= 0) {
        alert('삭제 할 회원을 선택하십시오.');
        return;
      }

      if (confirm('선택하신 회원을 영구 삭제하시겠습니까?')) {
        $("#sKind").val("E");
        $("#frmSearch").attr("method", "post").attr("action", "/actionUsers");
        $("#frmSearch").submit();
      }
    }
    function fnMemCnl(){
      var frmObj = "#frmSearch";
      if (fnSelBoxCnt($(frmObj + " input[class='chkMemCode']")) <= 0) {
        alert('탈퇴 취소 변경 할 회원을 선택하십시오.');
        return;
      }
      $("#sKind").val("C");
      $("#frmSearch").attr("method", "post").attr("action", "/actionUsers");
      $("#frmSearch").submit();
    }
    function fnMemExl() {
      $("#sKind").val("A");
      $("#frmSearch").attr("method", "post").attr("action", "./actionUsers").attr("target", "prcFrm");
      $("#frmSearch").submit();
    }
</script>

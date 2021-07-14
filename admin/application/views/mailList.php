<?php $ss= 0;
   if($pf==null) $ss = $uc;
   if($pf!=null) $ss = $uc-$pf; ?>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>회원리스트</h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <form name="frmList" id="frmList" method="get" action="<?=base_url()?>userListing">
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
                           <option value="F" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="F" ? "selected":""?>>이메일</option>
                           <option value="D" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="D" ? "selected":""?>>닉네임</option>
                           <option value="E" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="E" ? "selected":""?>>아이피주소</option>
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
            <form id="frmSearch">
                <input type="hidden" name="sKind" id="sKind">
                <input type="hidden" name="level" id="level">
                <input type="hidden" name="role" id="role">
                <table class="table table-bordered table-striped">
                   <tr class="thead-dark">
                      <th><input type="checkbox" name="chkMemCodeAll" id="chkMemCodeAll" value="Y"
                         onclick="fnCkBoxAllSel( 'frmSearch', 'chkMemCodeAll', 'chkMemCode' );">Id</th>
                      <th>회원명(아이디)</th>
                      <th>닉네임[등급]</th>
                      <th>코인</th>
                      <th>당근</th>
                      <th>핸드폰</th>
                      <th>Email</th>
                      <th>가입일</th>
                      <th>아이피주소</th>
                      <th class="text-center"></th>
                   </tr>
                   <?php
                      if(!empty($userRecords))
                      {
                          foreach($userRecords as $record)
                          {
                      ?>
                   <tr>
                      <td><input type="checkbox" name="chkMemCode[]" class="chkMemCode" value="<?=$record->userId ?>"><?=$ss ?></td>
                      <td><a data-toggle="tooltip" class="hastip"  data-uname="<?=$record->nickname?>" data-bullet = "<?=$record->bullet?>"
                         data-userid="<?=$record->userId?>"><?=$record->name?>(<?=$record->loginId?>)</a>
                      </td>
                      <td><?=$record->nickname ?>[<?=$record->codename?>]</td>
                      <td><?=$record->coin?></td>
                      <td><?=$record->bullet?></td>
                      <td><?=$record->phoneNumber?></td>
                      <td><?=$record->email ?></td>
                      <td><?=$record->created_at?></td>
                      <td><?=$record->ip?></td>
                      <td class="text-center">
                         <a class="btn btn-sm btn-info" href="<?php echo base_url().'editOld/'.$record->userId; ?>">
                           <i class="fa fa-pencil"></i>
                         </a>
                         <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php echo $record->userId; ?>">
                           <i class="fa fa-trash"></i>
                         </a>
                         <?php if(!empty($record->ip_block)): ?>
                           <a class="btn btn-sm btn-danger ipblock" href="#" data-userid="<?php echo $record->userId; ?>" data-mode="enable" data-ip="<?=$record->ip?>">
                             아이피차단해제
                           </a>
                         <?php endif;?>
                         <?php if(empty($record->ip_block)): ?>
                           <a class="btn btn-sm btn-danger ipblock" href="#" data-userid="<?php echo $record->userId; ?>" data-mode="disable" data-ip="<?=$record->ip?>">
                             아이피차단
                           </a>
                         <?php endif;?>
                      </td>
                   </tr>
                   <?php
                      $ss=$ss-1;
                      }
                    }
                    ?>
                </table>
            </form>
            <div>
                <?php echo $this->pagination->create_links(); ?>
             </div>
            <div>
              <select name="sMemLvlChk" id="sMemLvlChk" class="vm">
                  <?php if(!empty($rolss)): ?>
                  <?php foreach($rolss as $vv): ?>
                  <option value="<?=$vv->code?>-<?=$vv->value1?>" roletext="<?=$vv->codename?>" level="<?=$vv->code?>"><?=$vv->codename?> (경험치 <?=$vv->value1?>이상)</option>
                  <?php endforeach; ?>
                  <?php endif; ?>
               </select>
               <button type="button" class="btn btn-sm btn-primary" onclick="fnMemLvlChk();">회원등급변경</button>
               <button type="button" class="btn btn-sm btn-primary" onclick="fnPopNtDet();">쪽지보내기</button>
               <button type="button" class="btn btn-sm btn-primary" onclick="fnMemDelChk();">탈퇴</button>
               <a href="<?php echo base_url(); ?>addNew" class="btn btn-sm btn-primary">회원가입</a>
            </div>
         </div>
      </div>
   </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
   $('.hastip').tooltipsy({
    content: function ($el, $tip) {
       return '<table width="130" cellspacing="5" style="margin-left:10px;"><tbody><tr><td><span class="bold">'+$el.data("uname")+'</span> ('+$el.data("bullet")+')</td></tr><tr>      <td>· <a href="/editOld/'+$el.data("userid")+'" target="_blank" class="popMem">회원정보보기</a></td></tr> <tr> <td>· <a href="javascript:fnPopWinCT(\'/pickHistory?userid='+$el.data("userid")+'\', \'MemNote\', 500, 300, \'N\');"  class="popMem">픽 전적 보기</a></td></tr></tbody></table>';
   },
   show: function (e, $el) {
       var cur_top = parseInt($el[0].style.top.replace(/[a-z]/g, ''))-20;
       $el.css({
           'top': cur_top + 'px',
           'display': 'block'
       })
   },
   offset: [0, 1],
   css: {
       'padding': '15px',
       'max-width': '200px',
       'color': '#303030',
       'background-color': '#f5f5b5',
       'border': '1px solid #deca7e',
       '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
       '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
       'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
       'text-shadow': 'none',
       'cursor':'pointer'
   }
   });



   function fnMemLvlChk(){
     var frmObj = "#frmSearch";
     if (fnSelBoxCnt($(frmObj + " input[class='chkMemCode']")) <= 0) {
       alert('등급을 변경 할 회원을 선택하십시오.');
       return;
     }
     $("#level").val($("#sMemLvlChk").val());
     $("#role").val($("#sMemLvlChk option:selected").attr("roletext"));
     $("#sKind").val("U");
     $("#frmSearch").attr("method", "post").attr("action", "/Mem_U");
     $("#frmSearch").submit();
   }
   function fnPopNtDet(){
     var frmObj = "#frmSearch";
     if (fnSelBoxCnt($(frmObj + " input[class='chkMemCode']")) <= 0) {
       alert('쪽지를 보낼 회원을 선택하십시오');
       return;
     }
     var reVal = fnGetChkboxValue($(frmObj + " input[class='chkMemCode']"));
     fnPopWinCT("/NtDet_W?chkMemCode="+reVal, "쪽지보내기", 800, 600, "N")
   }
   function fnMemDelChk(){
     var frmObj = "#frmSearch";
     if (fnSelBoxCnt($("input[class='chkMemCode']")) <= 0) {
     alert('탈퇴 대기 할 회원을 선택하십시오.');
     return;
     }
     $("#sKind").val("D");
     $("#frmSearch").attr("method", "post").attr("action", "/admin/Mem_U").attr("target", "prcFrm");
     $("#frmSearch").submit();
   }

   function fnMemExl() {
     $("#sKind").val("");
     $("#frmSearch").attr("method", "post").attr("action", "/admin/Mem_X").attr("target", "prcFrm");
     $("#frmSearch").submit();
   }
</script>

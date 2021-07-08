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
           <form name="frmList" id="frmList" method="get" action="<?=base_url()?>usedItem">
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
                       </select>
                    </div>
                    <!-- <div class="pull-right">
                       <label style="display:block; ">상태</label>
                       <select name="use" id="use" class="form-control input-sm">
                          <option value="" <?=empty($_GET['use']) ? "selected":""?>>전체</option>
                          <option value="구매" <?=empty($_GET['use'])==0 && $_GET['use'] =="구매" ? "selected":""?>>구매</option>
                          <option value="사용" <?=empty($_GET['use'])==0 && $_GET['use'] =="사용" ? "selected":""?>>사용</option>
                       </select>
                    </div> -->
                 </div>
              </div>
           </form>
            <form id="frmSearch">
                <table class="table table-bordered table-striped">
                   <tr class="thead-dark">
                      <th>번호</th>
                      <th>닉네임</th>
                      <th>상태</th>
                      <th>아이템명</th>
                      <th>수량</th>
                      <th>총금액</th>
                      <th>일시</th>
                   </tr>
                   <?php
                      if(!empty($item))
                      {
                          foreach($item as $record)
                          {
                            $parsed_content = json_decode($record->content);
                      ?>
                   <tr class="align-middle">
                      <td><?=$ss ?></td>
                      <td><a href="/userListing?content=<?=$record->nickname?>&shType=D&ends_date=&starts_date=&shPageSize=10" target="_blank"><?=$record->nickname?></td>
                      <td><span class="<?=$parsed_content->class?> text-<?=$parsed_content->class == "use" ? "danger" :"primary"?>"><?=$parsed_content->use?></span></td>
                      <td><?=$parsed_content->name?></td>
                      <td><?=$parsed_content->count?></td>
                      <td><?=$parsed_content->price?></td>
                      <td><?=$record->created_at?></td>
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
         </div>
      </div>
   </section>
</div>

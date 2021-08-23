 <?php
$item = array();
$item['use'] = "사용";
$item['purchase'] = "구매";
 ?>
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>로그관리</h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
           <div class="btn-group" role="group" aria-label="Basic example">
              <a href="<?=base_url()?>logList?type=1" class="btn <?=empty($this->input->get("type")) || $this->input->get("type")== "1" ? "btn-danger":"btn-primary"?>">일일 첫 로그인</a>
              <a href="<?=base_url()?>logList?type=2" class="btn <?=$this->input->get("type")== "2" ? "btn-danger":"btn-primary"?>">아이템로그</a>
              <a href="<?=base_url()?>logList?type=3" class="btn <?=$this->input->get("type")== "3" ? "btn-danger":"btn-primary"?>">닉네임변경로그</a>
              <a href="<?=base_url()?>logList?type=4" class="btn <?=$this->input->get("type")== "4" ? "btn-danger":"btn-primary"?>">선물로그</a>
            </div>
         </div>
         <div class="col-xs-12" style="margin-top:10px">
           <form name="frmList" id="frmList" method="get" action="<?=base_url()?>logList">
            <div class="box-tools">
                <div class="input-group">
                  <input type="hidden" name="type" value="<?=$this->input->get('type')?>">
                  <div class="pull-right">
                    <label style="display:block; ">&nbsp;</label>
                    <input class="btn btn-primary btn-sm" value="검색" type="submit">
                 </div>
                 <div class="pull-right">
                    <label style="display: block;">검색어</label>
                    <input type="text" name="search" class="form-control input-sm"
                       value="<?=empty($_GET['search']) == 0 ? $_GET['search']:"" ?>">
                 </div>
                </div>
              </div>
           </form>
         </div>
         <div class="col-xs-12" style="margin-top:10px">
         	<div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover table-bordered table-striped table-responsive">
                    <tr class="thead-dark">
                      <th>id</th>
                      <th>닉네임</th>
                      <th>아이피</th>
                      <th>이유</th>
                      <th>창조일</th>
                    </tr>
                    <tbody class="wrap">  
                      <?php if(!empty($log)): ?>
                        <?php foreach($log  as $value): ?>
                        	<?php $j_parse = json_decode($value->content); ?>
                          <tr data-id="<?=$value->id?>" class="wrap_tr mid">
                            <td class="mid"><?=$value->id?></td>
                            <td class="mid"><?=$value->nickname?></td>
                            <td class="mid"><?=$value->ip?></td>
                            <?php if(empty($this->input->get('type')) || $this->input->get('type') ==1): ?>
                            <td class="mid">
                            	<p>경험치 : <?=$j_parse->exp?></p>
                            	<p><?=$j_parse->msg?></p>
                            </td>
                        	<?php endif;?>
                        	<?php if($this->input->get('type') ==2): ?>
                            <td class="mid">
                            <?=$j_parse->name?>(<?=$item[$j_parse->class]?>)	
                            <p>개수 : <?=$j_parse->count?> 가격: <?=$j_parse->price?></p>
                            </td>
                        	<?php endif;?>
                        	<?php if($this->input->get('type') ==3): ?>
                            <td class="mid">
                            	<p>이전 닉네임 : <?=$j_parse->old?></p>
                            	<p>현재 닉네임 : <?=$j_parse->new?></p>
                            </td>
                        	<?php endif;?>
                        	<?php if($this->input->get('type') ==4): ?>
                            <td class="mid">
                            	<p><?=$value->userId == $value->fromId ?  "[".$j_parse->type."] 선물" : "[".$j_parse->type."] 선물 받음"?></p>
                            	개수 : <?=$j_parse->count?>
                            </td>
                        	<?php endif;?>
                        	<td class="mid"><?=date("Y-m-d H:i:s",strtotime($value->created_at))?></td>
                          </tr>
                        <?php endforeach; ?>  
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="body-footer">
                <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->	
         </div>
     </div>
 </section>
</div>
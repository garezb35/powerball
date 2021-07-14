<?php

$use = 1;
$title = "";
$content = "";
$order = 1;
$id = 0;

if(!empty($page)){
  foreach($page as $v){
    $use = $v->use;
    $title = $v->title;
    $content = $v->content;
    $order = $v->order;
    $id = $v->id;
  }
}

?>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>페지관리</h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
           <div class="btn-group" role="group" aria-label="Basic example">
              <a href="<?=base_url()?>views?type=agree" class="btn <?=$this->input->get("type")== "agree" ? "btn-danger":"btn-primary"?>">이용약관</a>
              <a href="<?=base_url()?>views?type=privacy" class="btn <?=$this->input->get("type")== "privacy" ? "btn-danger":"btn-primary"?>">개인정보처리방침</a>
              <a href="<?=base_url()?>views?type=youth" class="btn <?=$this->input->get("type")== "youth" ? "btn-danger":"btn-primary"?>">청소년보호정책</a>
              <a href="<?=base_url()?>views?type=rejectemail" class="btn <?=$this->input->get("type")== "rejectemail" ? "btn-danger":"btn-primary"?>">이메일주소무단수집거부</a>
            </div>
         </div>
         <div class="col-xs-8" style="margin-top:10px">
           <div class="box box-primary" style="padding:10px">
             <form method="POST" action="<?=base_url()?>updateViews" id="frmSearch">
               <input type="hidden" name="id" value="<?=$id?>" />
               <input type="hidden" class="form-control" name="type" value="<?=$this->input->get("type")?>" />
               <div class="form-group">
                  <label for="content">제목</label>
                  <input type="text" class="form-control" name="title" value="<?=$title?>" />
               </div>
               <div class="form-group">
                  <input class="form-check-input" type="radio" name="use" value="1" id="use1"
                  <?=$use == 1 ? "checked": ""?> >
                  <label class="form-check-label" for="use1">
                    사용함
                  </label>
                  &nbsp;&nbsp;&nbsp;
                  <input class="form-check-input" type="radio" name="use" value="0" id="use0" <?=$use == 0 ? "checked": ""?>>
                  <label class="form-check-label" for="use0">
                    사용하지 않음
                  </label>
               </div>
               <div class="form-group">
                  <label for="content">페지순위</label>
                  <input type="hidden" class="form-control" name="order" value="1"/>
               </div>
               <div class="form-group">
                   <label for="content">내용</label>
                   <script src="/assets/smart/js/HuskyEZCreator.js"></script>
                   <script>var g5_editor_url = "/assets/smart", oEditors = [];</script>
                   <script src="/assets/smart/config.js"></script>
                   <textarea class="form-control smarteditor2" id="wr_content" name="content"  id="wr_content"><?=$content?></textarea>
               </div>
               <div class="form-group">
                 <input type="submit" class="btn btn-primary" value="확인">
                 <input type="reset" class="btn btn-secondary" value="복귀">
               </div>
             </form>
           </div>
         </div>
      </div>
   </section>
</div>
<script>
    $(document).ready(function(){
      $("#frmSearch").submit(function(){
        oEditors.getById["wr_content"].exec("UPDATE_CONTENTS_FIELD", []);
      })
    })
</script>

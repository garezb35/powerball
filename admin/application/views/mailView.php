<?php
  $tt = is_null($pf) ? $uc:$uc-$pf;
?>
<?php
  if(empty($panel)) { echo '해당 게시판이 존재하지 않습니다.'; } ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$panel[0]->content?></h1>
    </section>
    <section class="content">
      <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?=base_url()?>bbs?btype=<?=$panel[0]->name?>">글쓰기</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box-tools">
                <form method="get" action="<?=base_url("panel")?>">
                  <input type="hidden" name="id" value="<?=$_GET['id']?>">
                  <div class="input-group" style="margin-bottom: 10px">
                    <div class="pull-right">
                      <input class="btn btn-primary btn-sm" value="검색" type="submit">
                   </div>
                   <div class="pull-right">
                      <input type="text" name="seach_input"  class="form-control input-sm" style="width: 150px;"
                      value="<?=empty($_GET['seach_input']) == 0 ? $_GET['seach_input']:"" ?>">
                   </div>
                   <div class="pull-right">
                      <select name="shCol" id="shCol" class="form-control input-sm">
                        <option value="title"
                         <?=empty($_GET['shCol']) == 0 && $_GET['shCol']=="title" ? "selected":"" ?>>제목</option>
                        <option value="username"
                          <?=empty($_GET['shCol']) == 0 && $_GET['shCol']=="username" ? "selected":"" ?>>글쓴이</option>
                        <option value="id"
                        <?=empty($_GET['shCol']) == 0 && $_GET['shCol']=="id" ? "selected":"" ?>>글번호</option>
                      </select>
                   </div>
                   <?php if($panel[0]->category_use==1):
                                       $category = explode("|", $panel[0]->category);   ?>
                    <div class="pull-right">
                      <select class="form-control input-sm" id="category" name="category" required>
                        <?php if(!empty($category)): ?>
                            <option value="total">==전체=</option>
                            <?php foreach($category as $value): ?>
                            <option value="<?=$value?>" <?=empty($_GET['category']) == 0 && $_GET['category']==$value ? "selected":"" ?>><?=$value?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                    </div>
                <?php endif; ?>
                </div>
                </form>
              </div>
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>순번</th>
                      <th>제목</th>
                      <?php if($panel[0]->name == "photo"): ?>
                      <th>이미지</th>
                      <?php endif; ?>
                      <th>작성자</th>
                      <th>등록일</th>
                      <th>조회수</th>
                    </tr>
                    <?php if(!empty($content)): ?>
                      <?php foreach($content as $value): ?>
                        <tr>
                          <td><?=$tt?></td>
                          <td>
                            <?php if($value->reply==1): ?>
                                <img src="<?=base_url_source()?>assets/images/powerball/icon_reply.png" style="margin-left:10px;" alt="답변글">
                            <?php endif; ?>
                            <?php if($value->security==1): ?>
                              <img src="<?=base_url()?>assets/images/icon_secret.gif">
                            <?php endif; ?>
                            <a href="<?=base_url()?>viewReq/<?=$value->id?>?board_type=<?=$this->input->get("id")?>">
                               <?php if($panel[0]->content=="이용후기"): ?>
                                <span class="grey1">[<?=$value->category?>]</span>
                              <?php endif; ?>
                              <?=$value->title?>
                                <?= $value->comment_count > 0 ? "<span class='recCnt'>[".$value->comment_count."]</span>":"" ?>
                            </a>
                          </td>
                          <?php if($panel[0]->name == "photo"): ?>
                          <td class="img_50">
                            <?php preg_match_all('/<img[^>]+>/i',$value->content, $result);
                            if(sizeof($result) > 0){
                              echo str_replace("/assets/upload/",base_url_source()."assets/upload/",$result[0][0]);
                            }
                            ?>
                          </td>
                          <?php endif; ?>
                          <td>
                            <a data-toggle="tooltip" class="hastip"  data-uname="<?=$value->UserName?>" data-userid="<?=$value->userId?>">
                            <?=$value->UserName?>
                            </a></td>
                          <td><?=$value->updated_at?></td>
                          <td><?=$value->view_count?></td>
                        </tr>
                        <?php $tt=$tt-1;?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<?php
  $id = "0";
  $title = "";
  $type = "";
  $postc = 0;
  $category_use = 1;
  $category = "";
  $state_use = 1;
  $state = "";
  $title_l = 0;
  $letter_l = 0;
  $sms = 1;
  $file_size = 0;
  $security = 0;
  $ins_title_use = 1;
  $ins_title = "";
  $num_use = 1;
  $writer_use = 1;
  $regidate_use = 1;
  $view_use = 1;
  $recommend_use = 1;
  $wrview_use = 0;
  $writing_use = "";
  $comment_use = 0;
  $download_use = 0;
  $content = "";
  if(!empty($board)):
    foreach($board as $value):
      $id = $value->id;
      $title = $value->content;
      $type = 0;
      $postc = 0;
      $category_use = $value->category_use;
      $category = $value->category;
      $state_use = 0;
      $state = 0;
      $title_l = 0;
      $letter_l = 0;
      $sms = 0;
      $file_size = 0;
      $security = $value->security;
      $ins_title_use = 0;
      $ins_title = 0;
      $num_use = 0;
      $writer_use = $value->writter_use;
      $regidate_use = 0;
      $view_use = $value->view_use;
      $recommend_use = $value->recommend_use;
      $wrview_use = 0;
      $writing_use = $value->writing_use;
      $comment_use = $value->comment_use;
      $download_use = 0;
    endforeach;
  endif;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        게시판 등록
      </h1>
    </section>

    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <form role="form" id="addUser" action="<?php echo base_url() ?>addBoard" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">게시판명</label>
                                        <input type="text" class="form-control" id="title" name="content" required value="<?=$title?>">
                                        <input type="hidden" name="id" value="<?=$id?>">
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_use">분류사용</label>
                                        <select class="form-control" id="category_use" name="category_use">
                                            <option value="1" <?php if($category_use==1) echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($category_use==0) echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">분류명(ex:잡담|유머|질문|답변)</label>
                                        <input type="text" class="form-control" id="category" name="category" value="<?=$category?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="security">비밀글사용</label>
                                        <select class="form-control" id="security" name="security">
                                            <option value="1" <?php if($security==1)
                                            echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($security==0)
                                            echo 'selected'; ?>>사용안함</option>
                                            <option value="-1" <?php if($security==-1)
                                            echo 'selected'; ?>>강제사용</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="writer_use">작성자 사용(리스트에서 작성자 사용 여부)</label>
                                        <select class="form-control" id="writer_use" name="writter_use">
                                            <option value="1" <?php if($writer_use==1)
                                            echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($writer_use==0)
                                            echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="view_use">조회수 사용(리스트에서 조회수 사용 여부)</label>
                                        <select class="form-control" id="view_use" name="view_use">
                                            <option value="1" <?php if($view_use==1)
                                            echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($view_use==0)
                                            echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="recommend_use">추천수 사용(리스트에서 추천수 사용 여부)</label>
                                        <select class="form-control" id="recommend_use" name="recommend_use">
                                            <option value="1" <?php if($recommend_use==1)
                                            echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($recommend_use==0)
                                            echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="comment_use">댓글사용</label>
                                        <select class="form-control" id="comment_use" name="comment_use">
                                          <option value="1" <?php if($comment_use==1)
                                          echo 'selected'; ?>>사용함</option>
                                          <option value="0" <?php if($comment_use==0)
                                          echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <a href="/board_settings" class="btn btn-default">취소</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

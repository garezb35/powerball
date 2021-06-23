<?php if(empty($board)) {echo "해당 게시가 존재하지 않습니다.";return;} ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        게시판 편집
        <small><?=$board[0]->btitle?></small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                    </div><!-- /.box-header -->
                    <!-- form start -->
                   <?php echo form_open_multipart('updateBoard', array('id' => 'frmSearch','name'=>'frmBbs')); ?>
                        <input type="hidden" name="board_type" id="board_type" value="<?=$this->input->get("board_type")?>">
                        <div class="box-body">
                            <div class="row">
                            	<input type="hidden" name="id" value="<?=$board[0]->id?>">
                                <?php if($board[0]->category_use==1): ?>
                                	<?php $category = explode("|", $board[0]->bcategory); ?>
                                <?php if(!empty($category)): ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="role">카테고리</label>
                                            <select class="form-control" id="category" name="category" required>
                                                <option value="">==선택==</option>
    											<?php foreach($category as $cvalue): ?>
                                                <option value="<?=$cvalue?>" <?=$cvalue==$board[0]->category ? "selected":""?>><?=$cvalue?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="title">제목</label>
                                        <input type="text" class="form-control" id="title"  name="title" required value="<?=$board[0]->title?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        &nbsp;
                                        <div>
                                            <label for="letter_l">공지글</label>
                                            <input type="checkbox" class="form-check-input" name="notice" value="1"
                                            <?php if($board[0]->notice > 0):?> checked <?php endif;?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="content">내용</label>
                                        <script src="/assets/smart/js/HuskyEZCreator.js"></script>
                                        <script>var g5_editor_url = "/assets/smart", oEditors = [];</script>
                                        <script src="/assets/smart/config.js"></script>
                                        <textarea class="form-control smarteditor2"  id="wr_content" name="content" required> <?=str_replace("/assets/upload",base_url_source()."assets/upload",$board[0]->content)?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="content">등록날자</label>
                                        <input type="date"  name="updated_at" value="<?=date("Y-m-d",strtotime($board[0]->updated_at))?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="content">조회수</label>
                                        <input type="text"  readonly value="<?=$board[0]->view_count?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <a  class="btn btn-default" href="/viewReq/<?=$board[0]->id?>">취소</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function fnBbsFileDel(val) {
        var frmObj = document.frmBbs;
        if (!confirm('해당 첨부파일을 삭제하시겠습니까?')) {
            return;
        }
        frmObj.sKind.value = 'D';
        frmObj.sFL_SEQ.value = val;
        frmObj.action = '/bbs_fl_D';
        frmObj.submit();
    }
    $(document).ready(function(){
      $("#frmSearch").submit(function(){
        oEditors.getById["wr_content"].exec("UPDATE_CONTENTS_FIELD", []);
      })
    })
</script>

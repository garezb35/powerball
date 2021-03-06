<?php if(empty($panel)) return; ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">
                    <?php echo form_open_multipart(base_url()."writePost/".$btype, array('id' => 'frmSearch','name'=>'frmBbs')); ?>
                        <div class="box-body">
                            <div class="row">
                                <?php if($panel[0]->category_use==1):
                                       $category = explode("|", $panel[0]->category);   ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="role">카테고리</label>
                                            <select class="form-control" id="category" name="category" required>
                                                <?php if(!empty($category)): ?>
                                                    <?php foreach($category as $value): ?>
                                                    <option value="<?=$value?>"><?=$value?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="fname">제목</label>
                                        <input type="text" class="form-control required" id="title" name="title" required>
                                    </div>
                                </div>
                                <?php if($this->input->get("id") > 0): ?>
                                  <input type="hidden"  name="keys" value="<?=$this->input->get("id")?>">
                                  <input type="hidden"  name="reply" value="1">
                                <?php endif; ?>
                                <?php if($this->input->get("to") > 0): ?>
                                    <input type="hidden" class="form-check-input" name="notice" value="0">
                                    <input type="hidden"  name="toId" value="<?=$this->input->get("to")?>">
                                    <input type="hidden"  name="fromId" value="0">
                                <?php endif; ?>
                                <?php if(empty($this->input->get("to"))): ?>
                                  <div class="col-md-2">
                                      <div class="form-group">
                                          &nbsp;
                                          <div>
                                              <label for="notice">공지글</label>
                                              <input type="checkbox" class="form-check-input" name="notice" value="1">
                                          </div>
                                      </div>
                                  </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="content">내용</label>
                                        <script src="/assets/smart/js/HuskyEZCreator.js"></script>
                                        <script>var g5_editor_url = "/assets/smart", oEditors = [];</script>
                                        <script src="/assets/smart/config.js"></script>
                                        <textarea class="form-control smarteditor2" id="wr_content" name="content"  id="wr_content"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <a href="/panel?id=<?=$panel[0]->name?>" class="btn btn-default">취소</a>
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

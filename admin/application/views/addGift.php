<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> 시상품관리
      </h1>
    </section>

    <section class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
                <div class="box box-primary">
                    <form role="form" id="addUser" action="<?php echo base_url() ?>updateWinGift" method="post" role="form">
                        <div class="box-body">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="code">등급</label>
                                      <select name="order" class="form-control">
                                        <option value="1">1위</option>
                                        <option value="2">2위</option>
                                        <option value="3">3위</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="bonus">아이템선택</label>
                                      <select name="market_id" class="form-control">
                                        <?php foreach($item as $i): ?>
                                        <option value="<?=$i->code?>"><?=$i->name?></option>
                                        <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="hot_icon">아이템 개수</label>
                                      <input  type="number" name="count" class="form-control" value="1" />
                                  </div>
                              </div>
                          </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <input type="reset" class="btn btn-default" value="재설정" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

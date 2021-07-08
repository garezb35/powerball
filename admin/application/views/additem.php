<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> 아이템관리
      </h1>
    </section>

    <section class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <form role="form" id="addUser" action="<?php echo base_url() ?>updateItem" method="post" role="form">
                        <div class="box-body">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="code">아이템 코드</label>
                                      <input class="form-control" type="text" readonly value="<?=$item[0]->code?>" />
                                      <input class="form-control" type="hidden" name="id" value="<?=$item[0]->id?>" />
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="name">아이템명</label>
                                      <input type="text" class="form-control" required id="name" name="name" value="<?=$item[0]->name?>">
                                  </div>
                              </div>
                          </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bonus">보너스경험치</label>
                                        <input type="text" class="form-control"  id="bonus" name="bonus" value="<?=$item[0]->bonus?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hot_icon">HOT ICON</label>
                                        <select name="hot_icon" class="form-control">
                                          <option value="0" <?=$item[0]->hot_icon == 0 ? "selected":""?>>사용안함</option>
                                          <option value="1" <?=$item[0]->hot_icon == 1 ? "selected":""?>>HOT</option>
                                          <option value="2" <?=$item[0]->hot_icon == 2 ? "selected":""?>>NEW</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="nickname">가격</label>
                                        <input type="number" class="form-control" id="price"  name="price" value="<?=$item[0]->price?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="price_type">가격단위</label>
                                        <select name="price_type" class="form-control">
                                          <option value="1" <?=$item[0]->price_type == 1 ? "selected":""?>>코인</option>
                                          <option value="2" <?=$item[0]->price_type == 2 ? "selected":""?>>도토리</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="gift_used">선물사용</label>
                                        <select name="gift_used" class="form-control">
                                          <option value="0" <?=$item[0]->gift_used == 0 ? "selected":""?>>사용금지</option>
                                          <option value="1" <?=$item[0]->gift_used == 1 ? "selected":""?>>선물사용</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="detail_count">묶음단위</label>
                                        <input type="number" class="form-control"  id="detail_count" name="detail_count" value="<?=$item[0]->detail_count?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="period">기간</label>
                                        <input type="text" class="form-control"  id="period" name="period" value="<?=$item[0]->period?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="old_price">이전 가격</label>
                                        <input type="text" class="form-control"  id="old_price" name="old_price" value="<?=$item[0]->old_price?>">
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

<?php

$userId = '';
$name = '';
$email = '';
$mobile = '';
$roleId = '';
$deposit = 0;
$point = 0;
$address = '';
$details = '';
$zip = '';
$telephone = '';
$loginId = '';
$nickname = '';
$createdDtm = '';
$log_date = '';
$birthday = '';
$log_num = 0;
$sEmailRcvYN = '';
$sSmsRcvYN = '';
$type  = "";
$complete_orders  = 0;
$exp = 0;
$mag = array();
if(!empty($role_manage))
    $mag = json_decode($role_manage[0]->content);
if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $userId = $uf->userId;
        $name = $uf->name;
        $email = $uf->email;
        $mobile = $uf->phoneNumber;
        $loginId = $uf->loginId;
        $nickname = $uf->nickname;
        $createdDtm = $uf->created_at;
        $roleId = $uf->level;
        $deposit = $uf->coin;
        $point = $uf->bullet;
        $exp = $uf->exp;
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> 회원관리
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <form role="form" action="<?php echo base_url() ?>editUser" method="post" id="editUser" role="form">
                <div class="col-md-8">
                  <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header">
                        </div><!-- /.box-header -->
                        <!-- form start -->

                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="loginId">아이디</label>
                                            <input type="text" class="form-control" id="loginId" name="loginId" value="<?php echo $loginId; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nickname">닉네임</label>
                                            <input type="text" class="form-control" id="nickname" name="nickname" value="<?php echo $nickname; ?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fname">Full Name</label>
                                            <input type="text" class="form-control" id="fname" placeholder="Full Name" name="name" value="<?php echo $name; ?>" maxlength="128">
                                            <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $email; ?>" maxlength="128">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cpassword">Confirm Password</label>
                                            <input type="password" class="form-control" id="cpassword" placeholder="Confirm Password" name="cpassword" maxlength="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">Mobile Number</label>
                                            <input type="text" class="form-control" id="mobile" name="phoneNumber" value="<?php echo $mobile; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select class="form-control" id="role" name="level">
                                                <option value="0">Select Role</option>
                                                <?php
                                                if(!empty($roles))
                                                {
                                                    foreach ($roles as $rl)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $rl->code; ?>" <?php if($rl->code == $roleId) {echo "selected=selected";} ?>><?php echo $rl->codename ?> (경험치 <?=$rl->value1?>이상)</option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="createdDtm">가입일</label>
                                            <input type="text" class="form-control" id="createdDtm"  disabled value="<?=$createdDtm?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exp">경험치</label>
                                            <input type="text" class="form-control" id="exp"  name="exp" value="<?=$exp?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="coin">코인</label>
                                            <input type="text" class="form-control" id="coin"  name="coin"
                                            value="<?=$deposit?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bullet">당근</label>
                                            <input type="text" class="form-control" id="bullet" name="bullet"
                                            value="<?=$point?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telephone">회원상태</label>
                                            <select class="form-control" id="isDeleted" name="isDeleted">
                                                <option value="0" selected>능동회원</option>
                                                <option value="1">탈퇴회원</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /.box-body -->
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <input type="reset" class="btn btn-default" value="취소" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>

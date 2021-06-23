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
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <form role="form" id="addUser" action="<?php echo base_url() ?>addNewUser" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="loginId">아이디</label>
                                        <input type="text" class="form-control" required id="loginId" name="loginId" onkeyup="fnRealIDChk();">
                                        <label id="idcheckresultname">중복확인을 하셔야됩니다.</label>
                                        <input type="hidden" name="IDCheck" id="IDCheck" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">이름</label>
                                        <input type="text" class="form-control" required id="name" name="name" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nickname">닉네임</label>
                                        <input type="text" class="form-control" id="nickname"  name="nickname" onkeyup="fnRealIDChk('nickname');">
                                        <label id="idcheckresultnickname">중복확인을 하셔야됩니다.</label>
                                        <input type="hidden" name="NickNameCheck" id="NickNameCheck" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phoneNumber">헨드폰&nbsp;&nbsp;&nbsp;</label>
                                        <input type="text" name="phoneNumber" id="phoneNumber" maxlength="4" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="level">등급</label>
                                        <select class="form-control" required id="level" name="level">
                                            <option>==선택==</option>
                                            <?php
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {   ?>
                                                    <option value="<?php echo $rl->code."-".$rl->value1 ?>"><?php echo $rl->codename ?>(경험치 <?=$rl->value1?>이상)</option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">이메일</label>
                                        <input type="text" class="form-control required email" id="email"  name="email" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">비번</label>
                                        <input type="password" class="form-control required" id="password"  name="password" maxlength="10">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword">비번 확인</label>
                                        <input type="password" class="form-control required equalTo" id="cpassword" name="cpassword" maxlength="10">
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
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>
<script>
    function fnRealIDChk(type = "name") {
        if(type == "name")
        {
          var sValId = $("input[name='loginId']").val();
          var idcheck = "IDCheck";
          var alias = "아이디"
        }
        else {
          var sValId = $("input[name='nickname']").val();
          var idcheck = "NickNameCheck";
          var alias = "닉네임"
        }
        var idcheckresult = 'idcheckresult'+type;
        var url = "/IdChk?"
            + "sMemId="+ sValId+"&type="+type;
        var returnvalue="";
        var IDReg = /^[A-z]+[A-z0-9]{3,19}$/g;
        if (!IDReg.test($.trim(sValId))){
            $("input[name='"+idcheck+"']").val("0");
            debugger;
            document.getElementById(idcheckresult).innerHTML = "<span class=\"active\">사용할 수 없는 "+alias+" 입니다.</span>";
        }else{
            returnvalue = DoCallbackCommon(url).trim();
            if (returnvalue=="0"){
                $("input[name='"+idcheck+"']").val("1");
                document.getElementById(idcheckresult).innerHTML = "<span class=\"active\">사용할 수 있는 "+alias+" 입니다.</span>";
            }else{
                $("input[name='"+idcheck+"']").val("0");
                document.getElementById(idcheckresult).innerHTML = "<span class=\"active\">사용할 수 없는 "+alias+" 입니다.</span>";
            }
        }
    }
    function openDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                if ( data.userSelectedType == "R" ) {
                    document.getElementById('ZIP').value = data.zonecode;
                    document.getElementById('ADDR_1').value = data.roadAddress;
                    document.getElementById('ADDR_2').focus();
                    //document.getElementById('ADDR_1_EN').value = data.addressEnglish;
                } else {
                    alert("지번주소가 아닌 도로명주소를 선택하십시오.");
                }
            }
        }).open();
    }
</script>

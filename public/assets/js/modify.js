$(document).ready(function(){

      $("#profileImg").change(function() {
        readURL(this);
      });
})

function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#profileImgArea').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

function inputCheck(){
    var data = {};
    if($("#actionType").val() == "nickname"){
        data = {
            type:"nickname",
            api_token:$("#token").val(),
            nickname: $("#nickname").val(),
        }
    }
    if($("#actionType").val() == "family"){
        data = {
            type:"family",
            api_token:$("#token").val(),
            family: $("#family").val(),
        }
    }
    if($("#actionType").val() == "todayMsg"){
        data = {
            type:"todayMsg",
            api_token:$("#token").val(),
            todayMsg: $("#todayMsg").val()
        }
    }
    $.ajax({
        type:'POST',
        url:'/api/user-modify',
        data:data,
        dataType:'json',
        success:function (data){
            if(data.status ==1){
                alert("성공적으로 변경되였습니다.");
                window.close();
                return;
            }
            if(data.status ==0){
                alert(data.msg);
            }
        },
        error:function(xhr){
            console.log(xhr)
        }
    });
}

function inputReset(){
    window.close()
}

function familyNickInit(){

    var   data = {
            type:"family-init",
            api_token:$("#token").val(),
            family: $("#family").val(),
        }

    $.ajax({
        type:'POST',
        url:'/api/user-modify',
        data:data,
        dataType:'json',
        success:function (data){
            if(data.status ==1){
                alert("초기화되였습니다.");
                window.close();
                return;
            }
            if(data.status ==0){
                alert(data.msg);
            }
        },
        error:function(xhr){
            console.log(xhr)
        }
    });
}

function imgCheck(){
    $.ajax({
        type:'POST',
        url:'/api/imgCheck',
        data:{api_token:$("#token").val()},
        dataType:'json',
        success:function (data){
            if(data.status ==1){

            }
            if(data.status ==0){
                alert(data.msg);
            }
        }
    });
}


function profileImgInit(){
    $.ajax({
        type:'POST',
        url:'/api/imgCheck',
        data:{api_token:$("#token").val(),type:"delete"},
        dataType:'json',
        success:function (data){
            alert(data.msg);
            if(data.status == 2){
                window.close();
            }
        }
    });
}

$(document).ready(function(){

    $('#securityPasswd1').focus();

    var currentKey = 1;
    var currentKey_re = 1;
    var numberArr = [];
    var numberArr_re = [];

    // 키패드 클릭시
    $('.pad li').click(function(){

        var isreset = $(this).hasClass('reset');
        var isdelete = $(this).hasClass('delete');

        if (isreset || isdelete)
        {
            return false;
        }
        else
        {
            if($('#focusType').val() == '1')
            {
                if (numberArr.length >= 8)
                {
                    alert('2차비밀번호는 숫자 8자만 가능합니다.');
                    return false;
                }

                var numberVal = $(this).text();
                $('#securityPasswd'+currentKey).val(numberVal);

                var securityPasswdArr = numberArr.push(numberVal);
                var securityPasswd = numberArr.join('');
                $('#securityPasswd').val(securityPasswd);

                currentKey++;
            }
            else if($('#focusType').val() == '2')
            {
                if(numberArr_re.length >= 8)
                {
                    alert('2차비밀번호는 숫자 8자만 가능합니다.');
                    return false;
                }

                var numberVal = $(this).text();
                $('#securityPasswd_re'+currentKey_re).val(numberVal);

                var securityPasswdArr = numberArr_re.push(numberVal);
                var securityPasswd = numberArr_re.join('');
                $('#securityPasswd_re').val(securityPasswd);

                currentKey_re++;
            }
        }
    });

    // reset
    $('.pad li.reset').click(function(){
        if($('#focusType').val() == '1')
        {
            numberArr = [];
            $('#securityPasswd').val('');

            for(var i=1;i<=currentKey;i++)
            {
                $('#securityPasswd'+i).val('');
            }

            currentKey = 1;
        }
        else if($('#focusType').val() == '2')
        {
            numberArr_re = [];
            $('#securityPasswd_re').val('');

            for(var i=1;i<=currentKey_re;i++)
            {
                $('#securityPasswd_re'+i).val('');
            }

            currentKey_re = 1;
        }
    });

    // delete
    $('.pad li.delete').click(function(){
        if($('#focusType').val() == '1')
        {
            numberArr.pop();
            securityPasswd = numberArr.join('');
            $('#securityPasswd').val(securityPasswd);

            if(currentKey > 1)
            {
                $('#securityPasswd'+(currentKey-1)).val('');
                currentKey--;
            }
        }
        else if($('#focusType').val() == '2')
        {
            numberArr_re.pop();
            securityPasswd = numberArr_re.join('');
            $('#securityPasswd_re').val(securityPasswd);

            if(currentKey_re > 1)
            {
                $('#securityPasswd_re'+(currentKey_re-1)).val('');
                currentKey_re--;
            }
        }
    });
});

function setPasswordFocus(value)
{
    $('#focusType').val(value);
    return false;
}

function setSecurityPasswd()
{
    var fn = document.forms.securityForm;
    var securityPasswdLength = fn.securityPasswd.value.length;

    if($("#securityPasswdUseYN").is(":checked") && securityPasswdLength < 8)
    {
        alert('2차비밀번호를 입력해주세요.');
    }
    else if($("#securityPasswdUseYN").is(":checked") && fn.securityPasswd_re.value.length < 8)
    {
        alert('2차비밀번호 확인을 입력해주세요.');
    }
    else if($("#securityPasswdUseYN").is(":checked") && fn.securityPasswd.value != fn.securityPasswd_re.value)
    {
        alert('2차비밀번호 확인이 일치하지 않습니다.');
    }
    else
    {
        $.ajax({
            url:"/api/setSecondPassword",
            type:'POST',
            dataType:'json',
            data:{
                "securityPasswd":$("#securityPasswd").val(),
                "securityPasswdUseYN":$("#securityPasswdUseYN").is(":checked"),
                "api_token":$("#api_token").val()
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function (data,textStatus){
                if(data.status == 1)
                {
                    alert(data.msg);
                    location.reload();
                }
                else
                {
                    alert(data.msg);
                }
            }
        });
    }
}

function securityConfirm()
{
    var fn = document.forms.securityForm;

    if(!fn.securityPasswd.value || fn.securityPasswd.value.length != 8)
    {
        alert('2차비밀번호를 입력해 주세요.');
        setPasswordFocus(1);
    }
    else
    {
        fn.submit();
    }
}

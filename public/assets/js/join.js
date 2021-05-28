function changeTab(type)
{
    if(type == 'id')
    {
        $('#findIdBox').show();
        $('#findPwBox').hide();
        $('.findBox').find('.id').find('a').addClass('on');
        $('.findBox').find('.pw').find('a').removeClass('on');
    }
    else if(type == 'pw')
    {
        $('#resultBox').hide();
        $('#findPwBox').show();
        $('#findIdBox').hide();
        $('.findBox').find('.pw').find('a').addClass('on');
        $('.findBox').find('.id').find('a').removeClass('on');
    }
}

function inputCheck()
{
    var fn = document.forms.memberForm;
    var valid = true;

    $('#findIdBox .guideMsg').each(function(){
        var checkYN = $(this).attr('checkYN');
        var chkType = $(this).attr('id').replace('ChkDiv','');
        var val = $(this).prev().children().val();

        if(!val)
        {
            $(this).prev().children().focus();
            valid = false;
            return false;
        }
    });

    if(valid)
    {
        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/api/checkID',
            data:{
                actionType:'findId',
                name:fn.name.value,
                mobile:fn.mobile.value
            },
            success:function(data,textStatus){
                if(data.status == 1)
                {
                    $('#resultBox').show();
                    $('#resultBox').html(data.msg);
                }
                else
                    alert(data.msg)
            }
        });
    }
}

function inputCheckPw()
{
    var fn = document.forms.pwForm;
    var valid = true;

    $('#findPwBox .guideMsg').each(function(){
        var checkYN = $(this).attr('checkYN');
        var chkType = $(this).attr('id').replace('ChkDiv','');
        var val = $(this).prev().children().val();

        if(!val)
        {
            $(this).prev().children().focus();
            valid = false;
            return false;
        }
    });

    if(valid)
    {
        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/api/checkID',
            data:{
                actionType:'findPw',
                userid:fn.userid.value,
                mobile:fn.mobile.value
            },
            success:function(data,textStatus){
                if(data.status == 1)
                {
                    $('#resultBox').show();
                    $('#resultBox').html(data.msg);
                }
                else
                    alert(data.msg)
            }
        }).fail(function(xhr){
            console.log(xhr)
        });
    }
}

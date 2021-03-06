
function checkAll(status)
{
    if(status == true)
    {
        $('.check').attr('checked',true);
    }
    else
    {
        $('.check').attr('checked',false);
    }
}

function getPage(page)
{
    // $.ajax({
    //     type:'POST',
    //     url:'/',
    //     data:{
    //         view:'action',
    //         action:'memo',
    //         actionType:actionType,
    //         searchType:searchTypeVal,
    //         searchVal:searchVal,
    //         page:page
    //     },
    //     dataType:'html',
    //     success:function (data,textStatus){
    //         $('#resultDiv').html(data);
    //     },
    //     error:function (xhr,textStatus,errorThrown){
    //         //alert('error'+(errorThrown?errorThrown:xhr.status));
    //     }
    // });
}
$(document).ready(function(){
    $('.listBox li').find('a').click(function(){
        $(this).closest('li').siblings().find('a').removeClass('on');
        $(this).addClass('on');

        var searchType = $(this).attr('rel');
        searchTypeVal = searchType;
        searchVal = '';
        $('#searchValue').val('');
        if(searchType == 'B')
        {
            actionType = 'blackList';
        }
        else
        {
            actionType = 'friendList';
        }
        getPage(page);
    });

    $('.tooltip-btn').click(function(){
        if($('.tooltip-content').is(':hidden'))
        {
            $('.tooltip-content').show();
        }
        else
        {
            $('.tooltip-content').hide();
        }

        if($('.tooltip-content2').is(':hidden'))
        {
            $('.tooltip-content2').show();
        }
        else
        {
            $('.tooltip-content2').hide();
        }
    });

    if(typeof viewed_count != "undefined" && viewed_count >= 0){
      opener.updateBullet(viewed_count,"#mail-count")
    }
});

function ajaxNicknameCheck()
{
    if(!$('#receiveNick').val())
    {
        alertifyByCommon('닉네임을 입력하세요.');
        $('#receiveNick').focus();
        return false;
    }
    $.ajax({
        type:'POST',
        url:'/api/checkNickName',
        data:{
            api_token : api_token,
            nickname:$('#receiveNick').val()
        },
        dataType:'html',
        success:function (data,textStatus){
            if(data == 'myself')
            {
                alertifyByCommon('자기 자신에게 메일을 보낼수 없습니다.');
            }
            else if(data == 'noexist')
            {
                alertifyByCommon('존재하지 않는 닉네임입니다.');
            }
            else if(data == 'success')
            {
                alertifyByCommon('존재하는 닉네임입니다.');
            }
            else if(data == 'leave')
            {
                alertifyByCommon('탈퇴한 회원입니다.');
            }
            else if(data == 'intercept')
            {
                alertifyByCommon('차단된 회원입니다.');
            }
            else if(data == 'error')
            {
                alertifyByCommon('잘못된 접근입니다.');
            }
        }
    });
}

function randomMemoCheck()
{
    var fn = document.forms.writeForm;
    fn.receiveNick.disabled = fn.randomMemo.checked;
}

function inputCheck()
{
    var fn = document.forms.writeForm;
    if(!fn.receiveNick.value && fn.randomMemo.checked == false)
    {
        alertifyByCommon('받는 사람 닉네임을 입력하세요.');
        fn.receiveNick.focus();
        return false;
    }
    else if(!fn.content.value.trim())
    {
        alertifyByCommon('쪽지 내용을 입력하세요.');
        fn.content.focus();
        return false;
    }
    else
    {
        if(is_admin == false)
        {
            var filterMsg = fn.content.value.replace(/\s+/g,'').toLowerCase();

            for(i=0;i<filterWordArr.length;i++)
            {
                if(filterMsg.indexOf(filterWordArr[i]) != -1)
                {
                    alertifyByCommon('해당 단어 [' + filterWordArr[i] + '] (은)는 입력 금지어입니다.');
                    fn.content.value = '';
                    return false;
                }
            }

            var chkReg = /[0-9]{4}/g;
            var subjectChk = fn.content.value.replace(/\s/gi,'');
            var subjectMatchArr = subjectChk.match(chkReg);
            var subjectMatchLength = (subjectMatchArr || []).length;
            var contentChk = fn.content.value.replace(/<img[^>]*>/gi,'').replace(/\s/gi,'');
            var contentMatchArr = contentChk.match(chkReg);
            var contentMatchLength = (contentMatchArr || []).length;

            if((subjectMatchLength >= 2 || contentMatchLength >= 2) && !confirm('전화번호 등 개인정보 등록시 경고없이 차단조치 됩니다. 작성하시겠습니까?'))
            {
                return false;
            }
        }

        if(fn.randomMemo.checked == true && !confirm('랜덤 쪽지 아이템을 사용하시겠습니까?'))
        {
            return false;
        }

        $.post('/api/sendMail',$('#writeForm').serialize(),function(data){
            if(data.status == 1)
            {
                opener.memoSend(data.tuseridKey);
                alertifyByCommon("발송되었습니다.");
                document.location.href = "/memo?type=send";
            }
            else
            {
                alertifyByCommon(data.msg);
            }
        },'json');
    }
}

function memoDel()
{
    checkFlag = 'N';
    for(i = 0;i < $('.check').length;i++)
    {
        if($('.check').eq(i).prop('checked') == true)
        {
            checkFlag = 'Y';
            break;
        }
    }

    if(checkFlag == 'N')
    {
        alertifyByCommon('삭제할 쪽지를 선택해주세요.');
        return false;
    }
    else if (confirm('선택된 쪽지를 삭제 하시겠습니까?'))
    {
        var fn = document.forms.memoForm;
        fn.action = "/deleteMemo"
        fn.method = 'post';
        fn.submit();
    }
}

function memoDel()
{
    if (confirm('쪽지를 삭제 하시겠습니까?'))
    {
        var fn = document.forms.memoForm;
        fn.action = "/deleteMemo"
        fn.method = 'post';
        fn.submit();
    }
}

function memoSave()
{
    if (confirm('쪽지를 보관 하시겠습니까?'))
    {
        var fn = document.forms.memoForm;
        fn.action = "/memoSave"
        fn.method = 'post';
        fn.submit();
    }
}

function memoReport()
{
    if(confirm('쪽지 내용을 신고하시겠습니까?'))
    {
        var fn = document.forms.memoForm;
        fn.action = "/memoReport"
        fn.method = 'post';
        fn.submit();
    }
}

function friendSearch(type)
{
    searchVal = $('#searchValue').val();
    location.href = "/memo?type="+type+"&nickname="+searchVal;
}

function listDel(type)
{
    checkFlag = 'N';
    for(i = 0;i < $('.check').length;i++)
    {
        if($('.check').eq(i).prop('checked') == true)
        {
            checkFlag = 'Y';
            break;
        }
    }

    if(type == 'fixed')
    {
        var msg = '고정멤버';
    }
    else if(type == 'friend')
    {
        var msg = '친구리스트';
    }
    else
    {
        var msg = '블랙리스트';
    }

    if(checkFlag == 'N')
    {
        alertifyByCommon('삭제할 회원을 선택해주세요.');
        return false;
    }
    else if (confirm('선택된 회원을 '+msg+'에서 삭제 하시겠습니까?'))
    {
        var fn = document.forms.friendListForm;
        fn.method = 'post';
        fn.friendType.value = type;
        fn.submit();
    }
}

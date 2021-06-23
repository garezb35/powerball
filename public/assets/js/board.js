var save_before = "";
var save_html = "";
function comment_box(comment_id,work)
{
    var el_id;

    // 댓글 아이디가 넘어오면 답변, 수정
    if(comment_id)
    {
        if(work == 'c')
        {
            el_id = 'reply_' + comment_id;
        }
        else
        {
            el_id = 'edit_' + comment_id;
        }
    }
    else
    {
        el_id = '';
    }

    if(save_before != el_id)
    {
        if(save_before)
        {
            document.getElementById(save_before).style.display = 'none';
            document.getElementById(save_before).innerHTML = '';
        }

        document.getElementById(el_id).style.display = 'block';
        var template = $("#reply-home").html();
        var compiled_template = Handlebars.compile(template);
        var rendered = compiled_template({});
        $("#"+el_id).html(rendered)

        // 댓글 수정
        if(work == 'cu')
        {
            document.getElementById('wr_content2').value = document.getElementById('save_comment_' + comment_id).value;

            if(typeof char_count != 'undefined')
            {
                check_byte('wr_content', 'char_count');
            }

            if(document.getElementById('secret_comment_'+comment_id).value)
            {
                document.getElementById('wr_secret').value = 'secret';
            }
            else
            {
                document.getElementById('wr_secret').value = '';
            }
        }

        document.getElementById('comment_id').value = comment_id;
        document.getElementById('w').value = work;
        save_before = el_id;
    }
}

function fviewcomment_submit(f)
{
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

    f.is_good.value = 0;

    var subject = '';
    var content = '';

    // 양쪽 공백 없애기
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
    f.wr_content.value = f.wr_content.value.replace(pattern,'');

    if(!f.wr_content.value)
    {
        alertifyByCommon("댓글 내용을 입력하세요.")
        f.wr_content.focus();
        return false;
    }

    if(typeof(f.wr_name) != 'undefined')
    {
        f.wr_name.value = f.wr_name.value.replace(pattern, "");
        if (f.wr_name.value == '')
        {

            alertifyByCommon("이름이 입력되지 않았습니다.")
            f.wr_name.focus();
            return false;
        }
    }


    document.getElementById('btn_submit').disabled = 'disabled';

    return true;
}

function comment_delete(id)
{
    var con =  confirm("이 댓글을 삭제하시겠습니까?");
    if(con){
        $.ajax({
            type: "POST",
            url: "/api/deleteComment",
            data:{id : id,api_token:api_token},
            dataType:"json"
        }).done(function(data) {
            alertifyByCommon(data.msg)
            if(data.status ==1){
                location.reload()
            }
        })
    }
}

$("#good_button").click(function() {

    var cid = $(this).attr("ref");
    var $tx = $("#bo_v_act_good");
    excute_good($(this),$tx,cid);
    return false;
});

function excute_good($el,$tx,$cid)
{
    $.post(
        "/api/setRecommend",
        { "id": $cid,api_token:api_token },
        function(data) {
            if(data.status ==0) {
                alertifyByCommon(data.msg)
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                $tx.text("이 글을 추천하셨습니다.");
                $tx.fadeIn(200).delay(2500).fadeOut(200);
            }
        }, "json"
    );
}

function del(id)
{
    if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
        $.ajax({
            type: "POST",
            url: "/api/deletePost",
            data:{id : id,api_token:api_token},
            dataType:"json"
        }).done(function(data) {
            alertifyByCommon(data.msg)
            if(data.status ==1){
                location.reload()
            }
        })
    }
}

$(document).ready(function (){
    setTimeout(function(){
        heightResize()
    },2000);
})

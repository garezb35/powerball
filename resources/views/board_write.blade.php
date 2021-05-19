@extends('includes.empty_header')
<script>
    var api_token = "{{$result["api_token"]}}";
    var board_category = "{{Request::get("board_category")}}";
</script>
@section("header")
    <script src="/assets/js/wrest.js"></script>
    <section id="bo_w">
        <h2 id="container_title">{{$result["board"]["content"]}} 글쓰기</h2>
        <form name="fwrite" id="fwrite" action="/writePost" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:100%">
            @csrf
            <input type="hidden" name="board_type" value="{{Request::get("board_type")}}">
            <input type="hidden" name="board_category" value="{{Request::get("board_category")}}">
            <input type="hidden" name="wr_id" value="{{Request::get("bid")}}">
            <input type="hidden" name="api_token" value="{{$result["api_token"]}}">
            <input type="hidden" name="rid" value="{{Request::get("rid")}}">
            <input type="hidden" name="reply" value="{{Request::get("reply")}}">
            <div class="tbl_frm01 tbl_wrap">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <div id="autosave_wrapper">
                                    <input type="text" name="wr_subject" value="{{$result["title"]}}" id="wr_subject" class="frm_input" size="50" maxlength="255">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="wr_content">
                                <span class="sound_only">웹에디터 시작</span>
                                <script src="/assets/smart/js/HuskyEZCreator.js"></script>
                                <script>var g5_editor_url = "/assets/smart", oEditors = [];</script>
                                <script src="/assets/smart/config.js"></script>
                                <textarea  id="wr_content" name="wr_content" class="smarteditor2" maxlength="65536" style="width: 100%; display: none;">
                                    {{$result["content"]}}
                                </textarea>
                                <span class="sound_only">웹 에디터 끝</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="btn_confirm">
                <input type="submit" value="글쓰기" id="btn_submit" accesskey="s" class="btn_submit">
                <a href="/board?board_type={{Request::get("board_type")}}&board_category={{Request::get("board_category")}}" class="btn_cancel">취소</a>
            </div>
        </form>
    </section>
@endsection
<script>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "html2";
            else
                obj.value = "html1";
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
        if(!f.wr_subject.value)
        {
            alert('제목을 입력하세요.');
            f.wr_subject.focus();
            return false;
        }

        var wr_content_editor_data = oEditors.getById['wr_content'].getIR();
        oEditors.getById['wr_content'].exec('UPDATE_CONTENTS_FIELD', []);
        if(jQuery.inArray(document.getElementById('wr_content').value.toLowerCase().replace(/^\s*|\s*$/g, ''), ['&nbsp;','<p>&nbsp;</p>','<p><br></p>','<div><br></div>','<p></p>','<br>','']) != -1){document.getElementById('wr_content').value='';}
        if (!wr_content_editor_data || jQuery.inArray(wr_content_editor_data.toLowerCase(), ['&nbsp;','<p>&nbsp;</p>','<p><br></p>','<p></p>','<br>']) != -1) { alert("내용을 입력해 주십시오."); oEditors.getById['wr_content'].exec('FOCUS'); return false; }

        var subject = "";
        var content = "";
        // $.ajax({
        //     url: g5_bbs_url+"/ajax.filter.php",
        //     type: "POST",
        //     data: {
        //         "subject": f.wr_subject.value,
        //         "content": f.wr_content.value
        //     },
        //     dataType: "json",
        //     async: false,
        //     cache: false,
        //     success: function(data, textStatus) {
        //         subject = data.subject;
        //         content = data.content;
        //     }
        // });
        //
        // if (subject) {
        //     alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        //     f.wr_subject.focus();
        //     return false;
        // }

        if (content) {
            alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
            if (typeof(ed_wr_content) != "undefined")
                ed_wr_content.returnFalse();
            else
                f.wr_content.focus();
            return false;
        }

        // if (document.getElementById("char_count")) {
        //     if (char_min > 0 || char_max > 0) {
        //         var cnt = parseInt(check_byte("wr_content", "char_count"));
        //         if (char_min > 0 && char_min > cnt) {
        //             alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
        //             return false;
        //         }
        //         else if (char_max > 0 && char_max < cnt) {
        //             alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
        //             return false;
        //         }
        //     }
        // }

        // (개인정보 등록 경고 문구)
        var chkReg = /[0-9]{4}/g;
        var subjectChk = f.wr_subject.value.replace(/\s/gi,'');
        var subjectMatchArr = subjectChk.match(chkReg);
        var subjectMatchLength = (subjectMatchArr || []).length;

        var contentChk = f.wr_content.value.replace(/<img[^>]*>/gi,'').replace(/\s/gi,'');
        var contentMatchArr = contentChk.match(chkReg);
        var contentMatchLength = (contentMatchArr || []).length;

        var bo_table = board_category;

        if(bo_table != 'qna' && (subjectMatchLength >= 2 || contentMatchLength >= 2) && !confirm('전화번호 등 개인정보 등록시 경고없이 차단조치 됩니다. 작성하시겠습니까?'))
        {
            return false;
        }

        document.getElementById("btn_submit").disabled = "disabled";
        return true;
    }
</script>


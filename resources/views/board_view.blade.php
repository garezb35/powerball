@extends('includes.empty_header')
<script>
    var api_token = "{{$result["api_token"]}}";
</script>
@section("header")
    @php
    $page = Request::get("page") ?? 1;
    $first_count = $result["board_count"] - 20 * ($page - 1);
    @endphp
  @if(!empty($result["article"]))
      @php
      $comment = array();
      $temp = array();
      $step  =1;
      $roots = [];
      $all = [];
      $lookup_table = [];
      if(!empty($result["comments"])){
          foreach($result["comments"] as $comment_key=>$citem){
                $lookup_table[$citem['parent']][$comment_key] = $citem['id'];
          }
      }
      @endphp
      <article id="bo_v">
          <div class="viewinfo">
              <div class="thumb">
                  @if($result["article"]["fromId"] == 0)
                  <img src="/assets/images/mine/profile.png">
                  @else
                      <img src="{{$result["article"]["send_usr"]["image"]}}">
                  @endif
              </div>
              <div class="title">
                  <h1>
                      @if($result["board"]["category_use"] == 1 && !empty($result["article"]["cateogry"]))
                          [{{$result["article"]["cateogry"]}}]
                      @endif
                       {{$result["article"]["title"]}}
              </div>
              <div class="info">
                  @if($result["article"]["fromId"] == 0)
                      <img src="/assets/images/powerball/class/M30.gif" width="32">
                      <a href="#" class="uname"><span class="sv_member">운영자</span></a><span class="bar">|</span>
                  @else
                      <img src="{{$result["article"]["send_usr"]["getLevel"]["value3"]}}">
                      <a href="#" class="uname"><span class="sv_member">{{$result["article"]["send_usr"]["nickname"]}}</span></a><span class="bar">|</span>
                  @endif

                  {{date("Y-m-d H:i",strtotime($result["article"]["created_at"]))}}
                      @if($result["board"]["view_use"] == "1")
                          <span class="bar">|</span>조회 @if(empty($result["article"]["views"])){{0}}@else{{sizeof($result["article"]["views"])}}@endif
                      @endif
                  @if($result["board"]["comment_use"] == 1)
                          <span class="bar">|</span> 댓글 @if(empty($result["article"]["comments"])){{0}}@else{{sizeof($result["article"]["comments"])}}@endif
                      @endif
              </div>
          </div>
          <section id="bo_v_atc">
              <div id="bo_v_con">
                  {!! $result["article"]["content"] !!}
              </div>
              @if($result["board"]["recommend_use"] ==1)
                  <div id="bo_v_act">
                    <span class="bo_v_act_gng">
                        <a href="javascript:void(0)" id="good_button" ref="{{Request::get("bid")}}">
                            <strong>
                                @if(empty($result["article"]["recommend"]))
                                0
                                @else
                                    {{sizeof($result["article"]["recommend"])}}
                                @endif
                            </strong><span>추천</span></a>
                        <b id="bo_v_act_good"></b>
                    </span>
                  </div>
              @endif
          </section>
      </article>
      @if($result["board"]["comment_use"] == 1)
      <aside id="bo_vc_w">
          <h2>댓글쓰기</h2>
          <form name="fviewcomment" action="/commentProcess" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
              @csrf
              <input type="hidden" name="w" value="c">
              <input type="hidden" name="bo_table" value="{{Request::get("board_category")}}">
              <input type="hidden" name="wr_id" value="{{Request::get("bid")}}">
              <input type="hidden" name="comment_id" value="0">
              <input type="hidden" name="board_type" value="{{Request::get("board_type")}}">
              <input type="hidden" name="page" value="{{$page}}">
              <input type="hidden" name="api_token" value="{{$result["api_token"]}}">
              <div class="userinfo">
                 @if(!empty($result["self"]))
                      <div class="thumb"><img src="{{$result["self"]["image"]}}"></div>
                      <div class="info"><img src="{{$result["self"]["getLevel"]["value3"]}}">
                          {{$result["self"]["nickname"]}}
                      </div>
                  @endif
              </div>

              <div class="comment">
                  <div class="textarea">
                      <textarea name="wr_content" placeholder="댓글 작성시 타인을 배려하는 마음을 담아 댓글을 남겨주세요."></textarea>
                  </div>
                  <button type="submit" class="btn_submit" title="등록" accesskey="s">등록</button>
              </div>

          </form>
      </aside>
      <section id="bo_vc">
          <h2>댓글</h2>
          <span class="cmtCnt"><strong>
                  @if(empty($result["article"]["comments"])){{0}}@else{{sizeof($result["article"]["comments"])}}@endif
              </strong>개</span>
          @if(!empty($result["article"]["comments"]))
          @php
              recursive_child_display($result["comments"], $lookup_table, 0,0,$result["userId"]);
          @endphp
          @endif
      </section>
      @endif
      <div id="bo_v_top">
          <ul class="bo_v_nb">
              @if(!empty($result["previous"]))
                  <li><a href="/board?board_type={{Request::get("board_type")}}&board_category={{Request::get("board_category")}}&bid={{$result["previous"]}}&page={{Request::get("page")}}" class="btn_b01">이전글</a></li>
              @endif
              @if(!empty($result["next"]))
                  <li><a href="/board?board_type={{Request::get("board_type")}}&board_category={{Request::get("board_category")}}&bid={{$result["next"]}}&page={{Request::get("page")}}" class="btn_b01">다음글</a></li>
              @endif
          </ul>
          <ul class="bo_v_com">
              @if( $result["userId"] != 0 && $result["userId"] == $result["article"]["fromId"])
              <li><a href="/board_write?board_type={{Request::get("board_type")}}&board_category={{Request::get("board_category")}}&page={{$page}}&bid={{Request::get("bid")}}" class="btn_b01">수정</a></li>
              <li><a href="#" class="btn_b01" onclick="del({{Request::get("bid")}}); return false;">삭제</a></li>
              @endif
              <li><a href="/board?board_type={{Request::get("board_type")}}&board_category={{Request::get("board_category")}}&page={{Request::get("page")}}" class="btn_b01">목록</a></li>
                @if($result["article"]["reply"] != 1 && $result["board"]["reply_use"] == 1)
                  <li><a href="/board_write?board_type={{Request::get("board_type")}}&board_category={{Request::get("board_category")}}&rid={{Request::get("bid")}}&reply=1" class="btn_b01">답변</a></li>
                @endif
          </ul>
      </div>
  @endif
<div class="categoryTit">
    <ul>
        @if($result["type"] == "community")
        @if(!empty($result["b1"]))
        @foreach($result["b1"]  as $v)
        <li><a href="{{"board"}}?board_type=community&board_category={{$v["name"]}}" @if(Request::get("board_category") == $v["name"]) class="on" @endif>{{$v["content"]}}</a></li>
        @endforeach
        @endif
        @elseif($result["type"] == "customer")
        @if(!empty($result["b2"]))
        @foreach($result["b2"]  as $v)
        <li><a href="{{"board"}}?board_type=customer&board_category={{$v["name"]}}" @if(Request::get("board_category") == $v["name"]) class="on" @endif>{{$v["content"]}}</a></li>
        @endforeach
        @endif
        <li><a href="{{route("prison")}}?page_type=prison" @if(Request::get("page_type") == "prison") class="on" @endif>정지</a></li>
        @else
        @if(!empty($result["b3"]))
        @foreach($result["b3"]  as $v)
        <li><a href="{{"board"}}?board_type=none&board_category={{$v["name"]}}" @if(Request::get("board_category") == $v["name"]) class="on" @endif>{{$v["content"]}}</a></li>
        @endforeach
        @endif
        @endif
    </ul>
</div>
<div class="tbl_head01 tbl_wrap">
    @if($result["board"]["name"] != "photo")
        <table class="table table-bordered" style="width:calc(100% - 1px)">
            <colgroup>
                <col width="60px">
                <col width="*">
                <col width="150px">
                <col width="70px">
            </colgroup>
            <thead>
            <tr>
                <th scope="col">번호</th>
                <th scope="col">제목</th>
                <th scope="col">글쓴이</th>
                <th scope="col" class="text-center">날짜</th>
                @if($result["board"]["view_use"] == "1")
                    <th scope="col" class="text-center">조회</th>
                @endif
                @if($result["board"]["recommend_use"] == "1")
                    <th scope="col" class="text-center">
                        추천
                    </th>
                @endif
            </tr>
            </thead>
            <tbody>
            @if(sizeof($result["list"]) > 0)
                @foreach($result["list"] as $mail)
                    <tr class="@if($mail["notice"] == 1){{'bo_notice'}}@endif  @if(Request::get("bid") == $mail["id"]) bgSelect @endif" @if($mail["active"] == 0) style="background-color:#efefef;" @endif>
                        <td class="td_num text-center">
                            @if(Request::get("bid") == $mail["id"])
                                <span class="bo_current">&gt;&gt;&gt;</span>
                            @else
                                @if($mail["active"] != "0")
                                    @if($mail["notice"] == 1)<img src="/assets/images/powerball/ico_notice.png" style="vertical-align:top;">
                                    @else
                                        {{$first_count}}
                                    @endif
                                @else
                                    <img src="/assets/images/powerball/ico_blind.png" style="vertical-align:top;">
                                @endif
                            @endif

                        </td>
                        <td class="td_subject">
                            @if($mail["active"] != "0")
                                @if($mail["reply"] == 1)
                                    <img src="/assets/images/powerball/icon_reply.png" style="margin-left:10px;" alt="답변글">
                                @endif
                                @if($result["board"]["security"] == 1 && (($mail["fromId"] != 0 && $mail["fromId"] != $result["userId"]) || ($mail["toId"] != 0 && $mail["toId"] != $result["userId"])))
                                    <a href="/bbs/board.php?bo_table=humor&amp;wr_id=1" onclick="
                                                                                                alertify.set('notifier','delay', 1);
                                                                                                alertify.set('notifier','position', 'top-center');
                                                                                                alertify.error('비밀글은 작성자와 운영진만 열람 가능합니다.');return false;">
                                        <span class="gray">비밀글로 작성된 글입니다.</span>
                                        <img src="/assets/images/powerball/icon_secret.png" alt="비밀글"><img src="/assets/images/powerball/icon_new.gif" alt="새글">
                                    </a>
                                @else
                                    <a href="board?board_type={{$result["type"]}}&board_category={{Request::get("board_category")}}&bid={{$mail["id"]}}&page={{$page}}">
                                        {{$mail["title"]}}
                                    </a>
                                @endif
                                @if($result["board"]["comment_use"] == "1")
                                    <span class="sound_only">댓글</span><span class="cnt_cmt">
                                     @if(sizeof($mail["comments"]) > 0)
                                            [{{sizeof($mail["comments"])}}]
                                     @endif
                                    </span><span class="sound_only">개</span>
                                @endif
                            @else
                                <div style="line-height:25px;color:#999;">본 게시글은 운영 정책 위반으로 블라인드 처리되었습니다.</div>
                            @endif
                        </td>
                        <td class="td_name sv_use">
                            @if($mail["fromId"] == 0)
                                <img src="/assets/images/powerball/class/M30.gif" width="32"> <span class="sv_member">운영자</span>
                            @else
                                <span class="sv_member">
                                <img src="{{$mail["send_usr"]["getLevel"]["value3"]}}" /> {{$mail["send_usr"]["nickname"]}}
                            </span>
                            @endif
                        </td>
                        <td class="td_date text-center">{{date("m-d",strtotime($mail["created_at"]))}}</td>
                        @if($result["board"]["view_use"] == "1")
                            <td class="td_num text-center">{{sizeof($mail["views"])}}</td>
                        @endif
                        @if($result["board"]["recommend_use"] == "1")
                            <td class="td_num text-center">{{sizeof($mail["recommend"])}}</td>
                        @endif
                    </tr>
                    @php
                        $first_count--;
                    @endphp
                    @endforeach
                    @endif
                    </tobdy>
        </table>
    @else
        @if(sizeof($result["list"]) > 0)
            <div class="photoList">
                <ul>
                    @foreach($result["list"] as $mail)
                        @php  @endphp
                        <li>
                            <a href="/board?board_type={{Request::get("board_type")}}&board_category={{Request::get("board_category")}}&bid={{$mail["id"]}}&page={{$page}}">
                            <span class="thumb">{!! extractImage($mail["content"]) !!}</span>
                            </a><div class="title"><a href="/bbs/board.php?bo_table=photo&amp;wr_id=6756"></a>
                            <a href="/board?board_type={{Request::get("board_type")}}&board_category={{Request::get("board_category")}}&bid={{$mail["id"]}}&page={{$page}}">{{$mail["title"]}}</a>
                                <span class="comment" style="color:yellow;">
                            @if(sizeof($mail["comments"]) > 0)
                                [{{sizeof($mail["comments"])}}]
                            @endif</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

        @endif
    @endif
    <div class="page">
        {{$result["list"]->links()}}
    </div>
</div>
@if($result["board"]["writter_use"] == "1")
<div class="bo_fx">
    <ul class="btn_bo_user">
        <li><a href="/board_write?board_type={{Request::get("board_type")}}&board_category={{Request::get("board_category")}}" class="btn btn-danger">글쓰기</a></li>
    </ul>
</div>
@endif
<div id="bo_sch">
    <form>
        <input type="hidden" name="board_type" value="{{Request::get("board_type")}}">
        <input type="hidden" name="board_category" value="{{Request::get("board_category")}}">
        <select name="sfl" id="sfl" >
            <option value="wr_subject" @if(Request::get("sfl") == "wr_subject") selected @endif>제목</option>
            <option value="wr_content" @if(Request::get("sfl") == "wr_content") selected @endif>내용</option>
            <option value="wr_subject||wr_content" @if(Request::get("sfl") == "wr_subject||wr_content") selected @endif>제목+내용</option>
            <option value="mb_id" @if(Request::get("sfl") == "mb_id") selected @endif>회원아이디</option>
            <option value="wr_name" @if(Request::get("sfl") == "wr_name") selected @endif>글쓴이</option>
        </select>
        <input type="text" name="stx" value="{{Request::get("stx")}}" id="stx" class="frm_input" size="15">
        <input type="image" src="https://www.powerballgame.co.kr/images/btn_search_off.png" value="검색" class="btn_search">
    </form>
</div>
@endsection
<script id="reply-home" type="text/x-handlebars-template">
    <form name="fviewcomment" action="/commentProcess" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
        @csrf
        <input type="hidden" name="w" value="c" id="w" />
        <input type="hidden" name="bo_table" value="humor" />
        <input type="hidden" name="wr_id" value="{{Request::get("bid")}}" />
        <input type="hidden" name="comment_id" value="0" id="comment_id" />
        <input type="hidden" name="sca" value="" />
        <input type="hidden" name="sfl" value="" />
        <input type="hidden" name="stx" value="" />
        <input type="hidden" name="spt" value="" />
        <input type="hidden" name="page" value="" />
        <input type="hidden" name="is_good" value="" />
        <input type="hidden" name="wr_secret" id="wr_secret" />
        <input type="hidden" name="api_token" id="{{$result["api_token"]}}" />
        <div class="comment">
            <div class="textarea">
                <textarea id="wr_content2" name="wr_content" placeholder="댓글 작성시 타인을 배려하는 마음을 담아 댓글을 남겨주세요."></textarea>
            </div>
            <button type="submit" class="btn_submit" title="등록" accesskey="s">등록</button>
        </div>
    </form>
</script>

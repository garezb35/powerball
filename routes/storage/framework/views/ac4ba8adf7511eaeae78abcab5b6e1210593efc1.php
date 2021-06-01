<script>
    var api_token = "<?php echo e($result["api_token"]); ?>";
</script>
<?php $__env->startSection("header"); ?>
    <?php
    $page = Request::get("page") ?? 1;
    $first_count = $result["board_count"] - 20 * ($page - 1);
    ?>
  <?php if(!empty($result["article"])): ?>
      <?php
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
      ?>
      <article id="bo_v">
          <div class="viewinfo">
              <div class="thumb">
                  <?php if($result["article"]["fromId"] == 0): ?>
                  <img src="/assets/images/mine/profile.png">
                  <?php else: ?>
                      <img src="<?php echo e($result["article"]["send_usr"]["image"]); ?>">
                  <?php endif; ?>
              </div>
              <div class="title">
                  <h1>
                      <?php if($result["board"]["category_use"] == 1 && !empty($result["article"]["cateogry"])): ?>
                          [<?php echo e($result["article"]["cateogry"]); ?>]
                      <?php endif; ?>
                       <?php echo e($result["article"]["title"]); ?>

              </div>
              <div class="info">
                  <?php if($result["article"]["fromId"] == 0): ?>
                      <img src="/assets/images/powerball/class/M30.gif">
                      <a href="#" class="uname"><span class="sv_member">운영자</span></a><span class="bar">|</span>
                  <?php else: ?>
                      <img src="<?php echo e($result["article"]["send_usr"]["getLevel"]["value3"]); ?>">
                      <a href="#" class="uname"><span class="sv_member"><?php echo e($result["article"]["send_usr"]["nickname"]); ?></span></a><span class="bar">|</span>
                  <?php endif; ?>

                  <?php echo e(date("Y-m-d H:i",strtotime($result["article"]["created_at"]))); ?>

                      <?php if($result["board"]["view_use"] == "1"): ?>
                          <span class="bar">|</span>조회 <?php if(empty($result["article"]["views"])): ?><?php echo e(0); ?><?php else: ?><?php echo e(sizeof($result["article"]["views"])); ?><?php endif; ?>
                      <?php endif; ?>
                  <?php if($result["board"]["comment_use"] == 1): ?>
                          <span class="bar">|</span> 댓글 <?php if(empty($result["article"]["comments"])): ?><?php echo e(0); ?><?php else: ?><?php echo e(sizeof($result["article"]["comments"])); ?><?php endif; ?>
                      <?php endif; ?>
              </div>
          </div>
          <section id="bo_v_atc">
              <div id="bo_v_con">
                  <?php echo $result["article"]["content"]; ?>

              </div>
              <?php if($result["board"]["recommend_use"] ==1): ?>
                  <div id="bo_v_act">
                    <span class="bo_v_act_gng">
                        <a href="javascript:void(0)" id="good_button" ref="<?php echo e(Request::get("bid")); ?>">
                            <strong>
                                <?php if(empty($result["article"]["recommend"])): ?>
                                0
                                <?php else: ?>
                                    <?php echo e(sizeof($result["article"]["recommend"])); ?>

                                <?php endif; ?>
                            </strong><span>추천</span></a>
                        <b id="bo_v_act_good"></b>
                    </span>
                  </div>
              <?php endif; ?>
          </section>
      </article>
      <?php if($result["board"]["comment_use"] == 1): ?>
      <aside id="bo_vc_w">
          <h2>댓글쓰기</h2>
          <form name="fviewcomment" action="/commentProcess" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
              <?php echo csrf_field(); ?>
              <input type="hidden" name="w" value="c">
              <input type="hidden" name="bo_table" value="<?php echo e(Request::get("board_category")); ?>">
              <input type="hidden" name="wr_id" value="<?php echo e(Request::get("bid")); ?>">
              <input type="hidden" name="comment_id" value="0">
              <input type="hidden" name="board_type" value="<?php echo e(Request::get("board_type")); ?>">
              <input type="hidden" name="page" value="<?php echo e($page); ?>">
              <input type="hidden" name="api_token" value="<?php echo e($result["api_token"]); ?>">
              <div class="userinfo">
                 <?php if(!empty($result["self"])): ?>
                      <div class="thumb"><img src="<?php echo e($result["self"]["image"]); ?>"></div>
                      <div class="info"><img src="<?php echo e($result["self"]["getLevel"]["value3"]); ?>">
                          <?php echo e($result["self"]["nickname"]); ?>

                      </div>
                  <?php endif; ?>
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
                  <?php if(empty($result["article"]["comments"])): ?><?php echo e(0); ?><?php else: ?><?php echo e(sizeof($result["article"]["comments"])); ?><?php endif; ?>
              </strong>개</span>
          <?php if(!empty($result["article"]["comments"])): ?>
          <?php
              recursive_child_display($result["comments"], $lookup_table, 0,0,$result["userId"]);
          ?>
          <?php endif; ?>
      </section>
      <?php endif; ?>
      <div id="bo_v_top">
          <ul class="bo_v_nb">
              <?php if(!empty($result["previous"])): ?>
                  <li><a href="/board?board_type=<?php echo e(Request::get("board_type")); ?>&board_category=<?php echo e(Request::get("board_category")); ?>&bid=<?php echo e($result["previous"]); ?>&page=<?php echo e(Request::get("page")); ?>" class="btn_b01">이전글</a></li>
              <?php endif; ?>
              <?php if(!empty($result["next"])): ?>
                  <li><a href="/board?board_type=<?php echo e(Request::get("board_type")); ?>&board_category=<?php echo e(Request::get("board_category")); ?>&bid=<?php echo e($result["next"]); ?>&page=<?php echo e(Request::get("page")); ?>" class="btn_b01">다음글</a></li>
              <?php endif; ?>
          </ul>
          <ul class="bo_v_com">
              <?php if( $result["userId"] != 0 && $result["userId"] == $result["article"]["fromId"]): ?>
              <li><a href="/board_write?board_type=<?php echo e(Request::get("board_type")); ?>&board_category=<?php echo e(Request::get("board_category")); ?>&page=<?php echo e($page); ?>&bid=<?php echo e(Request::get("bid")); ?>" class="btn_b01">수정</a></li>
              <li><a href="#" class="btn_b01" onclick="del(<?php echo e(Request::get("bid")); ?>); return false;">삭제</a></li>
              <?php endif; ?>
              <li><a href="/board?board_type=<?php echo e(Request::get("board_type")); ?>&board_category=<?php echo e(Request::get("board_category")); ?>&page=<?php echo e(Request::get("page")); ?>" class="btn_b01">목록</a></li>
                <?php if($result["article"]["reply"] != 1 && $result["board"]["reply_use"] == 1): ?>
                  <li><a href="/board_write?board_type=<?php echo e(Request::get("board_type")); ?>&board_category=<?php echo e(Request::get("board_category")); ?>&rid=<?php echo e(Request::get("bid")); ?>&reply=1" class="btn_b01">답변</a></li>
                <?php endif; ?>
          </ul>
      </div>
  <?php endif; ?>
<div class="categoryTit">
    <ul>
        <?php if($result["type"] == "community"): ?>
        <li><a href="<?php echo e("board"); ?>?board_type=community&board_category=offten" <?php if(Request::get("board_category") == "offten"): ?> class="on" <?php endif; ?>>자주 하시는 질문</a></li>
        <li><a href="<?php echo e("board"); ?>?board_type=community&board_category=private" <?php if(Request::get("board_category") == "private"): ?> class="on" <?php endif; ?>>1:1문의</a></li>
        <li><a href="<?php echo e("board"); ?>?board_type=community&board_category=advanced" <?php if(Request::get("board_category") == "advanced"): ?> class="on" <?php endif; ?>>기능개선요청</a></li>
        <?php elseif($result["type"] == "customer"): ?>
        <li><a href="<?php echo e("board"); ?>?board_type=customer&board_category=notice" <?php if(Request::get("board_category") == "notice"): ?> class="on" <?php endif; ?>>공지사항</a></li>
        <li><a href="<?php echo e("board"); ?>?board_type=customer&board_category=event" <?php if(Request::get("board_category") == "event"): ?> class="on" <?php endif; ?>>이벤트</a></li>
        <li><a href="#">영창</a></li>
        <?php else: ?>
        <li><a href="<?php echo e("board"); ?>?board_type=none&board_category=humor" <?php if(Request::get("board_category") == "humor"): ?> class="on" <?php endif; ?>>유버</a></li>
        <li><a href="<?php echo e("board"); ?>?board_type=none&board_category=photo" <?php if(Request::get("board_category") == "photo"): ?> class="on" <?php endif; ?>>포토</a></li>
        <li><a href="<?php echo e("board"); ?>?board_type=none&board_category=pick" <?php if(Request::get("board_category") == "pick"): ?> class="on" <?php endif; ?>>분석픽공유</a></li>
        <li><a href="<?php echo e("board"); ?>?board_type=none&board_category=free" <?php if(Request::get("board_category") == "free"): ?> class="on" <?php endif; ?>>자유</a></li>
        <?php endif; ?>
    </ul>
</div>
<div class="tbl_head01 tbl_wrap">
    <?php if($result["board"]["name"] != "photo"): ?>
        <table class="table table-bordered">
            <colgroup>
                <col width="60px">
                <col>
                <col width="150px">
                <col width="70px">
                <col width="60px">
                <col width="60px">
            </colgroup>
            <thead>
            <tr>
                <th scope="col">번호</th>
                <th scope="col">제목</th>
                <th scope="col">글쓴이</th>
                <th scope="col" class="text-center"><a href="#">날짜</a></th>
                <?php if($result["board"]["view_use"] == "1"): ?>
                    <th scope="col" class="text-center"><a href="#">조회</a></th>
                <?php endif; ?>
                <?php if($result["board"]["recommend_use"] == "1"): ?>
                    <th scope="col" class="text-center">
                        추천
                    </th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php if(sizeof($result["list"]) > 0): ?>
                <?php $__currentLoopData = $result["list"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="<?php if($mail["notice"] == 1): ?><?php echo e('bo_notice'); ?><?php endif; ?>  <?php if(Request::get("bid") == $mail["id"]): ?> bgSelect <?php endif; ?>" <?php if($mail["active"] == 0): ?> style="background-color:#efefef;" <?php endif; ?>>
                        <td class="td_num text-center">
                            <?php if(Request::get("bid") == $mail["id"]): ?>
                                <span class="bo_current">&gt;&gt;&gt;</span>
                            <?php else: ?>
                                <?php if($mail["active"] != "0"): ?>
                                    <?php if($mail["notice"] == 1): ?><img src="/assets/images/powerball/ico_notice.png" style="vertical-align:top;">
                                    <?php else: ?>
                                        <?php echo e($first_count); ?>

                                    <?php endif; ?>
                                <?php else: ?>
                                    <img src="/assets/images/powerball/ico_blind.png" style="vertical-align:top;">
                                <?php endif; ?>
                            <?php endif; ?>

                        </td>
                        <td class="td_subject">
                            <?php if($mail["active"] != "0"): ?>
                                <?php if($mail["reply"] == 1): ?>
                                    <img src="/assets/images/powerball/icon_reply.png" style="margin-left:10px;" alt="답변글">
                                <?php endif; ?>
                                <?php if($result["board"]["security"] == 1 && (($mail["fromId"] != 0 && $mail["fromId"] != $result["userId"]) || ($mail["toId"] != 0 && $mail["toId"] != $result["userId"]))): ?>
                                    <a href="/bbs/board.php?bo_table=humor&amp;wr_id=1" onclick="alert('비밀글은 작성자와 운영진만 열람 가능합니다.');return false;">
                                        <span class="gray">비밀글로 작성된 글입니다.</span>
                                        <img src="/assets/images/powerball/icon_secret.png" alt="비밀글"><img src="/assets/images/powerball/icon_new.gif" alt="새글">
                                    </a>
                                <?php else: ?>
                                    <a href="board?board_type=<?php echo e($result["type"]); ?>&board_category=<?php echo e(Request::get("board_category")); ?>&bid=<?php echo e($mail["id"]); ?>&page=<?php echo e($page); ?>">
                                        <?php echo e($mail["title"]); ?>

                                    </a>
                                <?php endif; ?>
                                <?php if($result["board"]["comment_use"] == "1"): ?>
                                    <span class="sound_only">댓글</span><span class="cnt_cmt">
                                     <?php if(sizeof($mail["comments"]) > 0): ?>
                                            [<?php echo e(sizeof($mail["comments"])); ?>]
                                     <?php endif; ?>
                                    </span><span class="sound_only">개</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <div style="line-height:25px;color:#999;">본 게시글은 운영 정책 위반으로 블라인드 처리되었습니다.</div>
                            <?php endif; ?>
                        </td>
                        <td class="td_name sv_use">
                            <?php if($mail["fromId"] == 0): ?>
                                <img src="/assets/images/powerball/class/M30.gif"> <span class="sv_member">운영자</span>
                            <?php else: ?>
                                <span class="sv_member">
                                <img src="<?php echo e($mail["send_usr"]["getLevel"]["value3"]); ?>" /> <?php echo e($mail["send_usr"]["nickname"]); ?>

                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="td_date text-center"><?php echo e(date("m-d",strtotime($mail["created_at"]))); ?></td>
                        <?php if($result["board"]["view_use"] == "1"): ?>
                            <td class="td_num text-center"><?php echo e(sizeof($mail["views"])); ?></td>
                        <?php endif; ?>
                        <?php if($result["board"]["recommend_use"] == "1"): ?>
                            <td class="td_num text-center"><?php echo e(sizeof($mail["recommend"])); ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php
                        $first_count--;
                    ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tobdy>
        </table>
    <?php else: ?>
        <?php if(sizeof($result["list"]) > 0): ?>
            <div class="photoList">
                <ul>
                    <?php $__currentLoopData = $result["list"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php  ?>
                        <li>
                            <a href="/board?board_type=<?php echo e(Request::get("board_type")); ?>&board_category=<?php echo e(Request::get("board_category")); ?>&bid=<?php echo e($mail["id"]); ?>&page=<?php echo e($page); ?>">
                            <span class="thumb"><?php echo extractImage($mail["content"]); ?></span>
                            </a><div class="title"><a href="/bbs/board.php?bo_table=photo&amp;wr_id=6756"></a>
                            <a href="/board?board_type=<?php echo e(Request::get("board_type")); ?>&board_category=<?php echo e(Request::get("board_category")); ?>&bid=<?php echo e($mail["id"]); ?>&page=<?php echo e($page); ?>"><?php echo e($mail["title"]); ?></a>
                                <span class="comment" style="color:yellow;">
                            <?php if(sizeof($mail["comments"]) > 0): ?>
                                [<?php echo e(sizeof($mail["comments"])); ?>]
                            <?php endif; ?></span>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

        <?php endif; ?>
    <?php endif; ?>
    <div class="page">
        <?php echo e($result["list"]->links()); ?>

    </div>
</div>
<?php if($result["board"]["writter_use"] == "1"): ?>
<div class="bo_fx">
    <ul class="btn_bo_user">
        <li><a href="/board_write?board_type=<?php echo e(Request::get("board_type")); ?>&board_category=<?php echo e(Request::get("board_category")); ?>" class="btn btn-danger">글쓰기</a></li>
    </ul>
</div>
<?php endif; ?>
<div id="bo_sch">
    <form>
        <input type="hidden" name="board_type" value="<?php echo e(Request::get("board_type")); ?>">
        <input type="hidden" name="board_category" value="<?php echo e(Request::get("board_category")); ?>">
        <select name="sfl" id="sfl" >
            <option value="wr_subject" <?php if(Request::get("sfl") == "wr_subject"): ?> selected <?php endif; ?>>제목</option>
            <option value="wr_content" <?php if(Request::get("sfl") == "wr_content"): ?> selected <?php endif; ?>>내용</option>
            <option value="wr_subject||wr_content" <?php if(Request::get("sfl") == "wr_subject||wr_content"): ?> selected <?php endif; ?>>제목+내용</option>
            <option value="mb_id" <?php if(Request::get("sfl") == "mb_id"): ?> selected <?php endif; ?>>회원아이디</option>
            <option value="wr_name" <?php if(Request::get("sfl") == "wr_name"): ?> selected <?php endif; ?>>글쓴이</option>
        </select>
        <input type="text" name="stx" value="<?php echo e(Request::get("stx")); ?>" id="stx" class="frm_input" size="15">
        <input type="image" src="https://www.powerballgame.co.kr/images/btn_search_off.png" value="검색" class="btn_search">
    </form>
</div>
<?php $__env->stopSection(); ?>
<script id="reply-home" type="text/x-handlebars-template">
    <form name="fviewcomment" action="/commentProcess" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="w" value="c" id="w" />
        <input type="hidden" name="bo_table" value="humor" />
        <input type="hidden" name="wr_id" value="<?php echo e(Request::get("bid")); ?>" />
        <input type="hidden" name="comment_id" value="0" id="comment_id" />
        <input type="hidden" name="sca" value="" />
        <input type="hidden" name="sfl" value="" />
        <input type="hidden" name="stx" value="" />
        <input type="hidden" name="spt" value="" />
        <input type="hidden" name="page" value="" />
        <input type="hidden" name="is_good" value="" />
        <input type="hidden" name="wr_secret" id="wr_secret" />
        <input type="hidden" name="api_token" id="<?php echo e($result["api_token"]); ?>" />
        <div class="comment">
            <div class="textarea">
                <textarea id="wr_content2" name="wr_content" placeholder="댓글 작성시 타인을 배려하는 마음을 담아 댓글을 남겨주세요."></textarea>
            </div>
            <button type="submit" class="btn_submit" title="등록" accesskey="s">등록</button>
        </div>
    </form>
</script>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/board_view.blade.php ENDPATH**/ ?>
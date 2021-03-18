@extends('includes.empty_header')
@section("header")
<div class="categoryTit">
    <ul style="background-color:#F1F1F1;">
        <li><a href="/bbs/board.php?bo_table=humor" class="on">유머</a></li>
        <li><a href="/bbs/board.php?bo_table=photo">포토</a></li>
        <li><a href="/bbs/board.php?bo_table=pick">분석픽공유</a></li>
        <li><a href="/bbs/board.php?bo_table=free">자유</a></li>
    </ul>
</div>
<div class="tbl_head01 tbl_wrap">
    <table class="table">
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
                <th scope="col"><a href="/bbs/board.php?bo_table=humor&amp;sop=and&amp;sst=wr_datetime&amp;sod=desc&amp;sfl=&amp;stx=&amp;page=1">날짜</a></th>
                <th scope="col"><a href="/bbs/board.php?bo_table=humor&amp;sop=and&amp;sst=wr_hit&amp;sod=desc&amp;sfl=&amp;stx=&amp;page=1">조회</a></th>
                <th scope="col"><a href="/bbs/board.php?bo_table=humor&amp;sop=and&amp;sst=wr_good&amp;sod=desc&amp;sfl=&amp;stx=&amp;page=1">추천</a></th>                    
            </tr>
        </thead>
        <tbody>
            <tr class="bo_notice bo_read">
                <td class="td_num">
                    <img src="https://simg.powerballgame.co.kr/images/ico_notice.png" style="vertical-align:top;">           
                </td>
                <td class="td_subject">
                    <a href="/bbs/board.php?bo_table=humor&amp;wr_id=1">
                        단순 유머만 등록하시기 바랍니다.                    
                        <span class="sound_only">댓글</span><span class="cnt_cmt">[9]</span><span class="sound_only">개</span>                
                    </a>
                </td>
                <td class="td_name sv_use"><img src="https://www.powerballgame.co.kr/images/class/M30.gif"> <span class="sv_member">운영자</span></td>
                <td class="td_date">08-21</td>
                <td class="td_num">16223</td>
                <td class="td_num">22</td>                    
            </tr>
            <tr  class="td_blind">
				<td class="td_num"><img src="https://simg.powerballgame.co.kr/images/ico_blind.png" style="vertical-align:top;"></td>
				<td style="td_subject">
					<div style="line-height:25px;color:#999;">본 게시글은 운영 정책 위반으로 블라인드 처리되었습니다.</div>
				</td>
				<td class="td_name sv_use"><img src="https://www.powerballgame.co.kr/images/class/M6.gif"> <span class="sv_member">일억만</span></td>
				<td class="td_date">01-31</td>
				<td class="td_num">10</td>
                <td class="td_num">0</td>							
            </tr>
            <tr class="bo_read td_blind">
				<td class="td_num"><img src="https://simg.powerballgame.co.kr/images/ico_blind.png" style="vertical-align:top;"></td>
				<td style="td_subject">
					<div style="line-height:25px;color:#999;">본 게시글은 운영 정책 위반으로 블라인드 처리되었습니다.</div>
				</td>
				<td class="td_name sv_use"><img src="https://www.powerballgame.co.kr/images/class/M6.gif"> <span class="sv_member">쉐보레</span></td>
				<td class="td_date">01-18</td>
				<td class="td_num">1557</td>
                <td class="td_num">2</td>							
            </tr>
            <tr class="">
                <td class="td_num">5374</td>
                <td class="td_subject">
                    <a href="/bbs/board.php?bo_table=humor&amp;wr_id=15503">
                        #공감<span class="sound_only">댓글</span>
                        <span class="cnt_cmt">[12]</span>
                        <span class="sound_only">개</span>                
                    </a>
                </td>
                <td class="td_name sv_use"><img src="https://www.powerballgame.co.kr/images/class/M18.gif"> <span class="sv_member">원태연</span></td>
                <td class="td_date">11-09</td>
                <td class="td_num">5812</td>
                <td class="td_num">10</td>                    
            </tr>
        </tobdy>
    </table>
</div>
<div class="bo_fx">
    <ul class="btn_bo_user">
        <li><a href="./write.php?bo_table=humor" class="btn btn-danger">글쓰기</a></li>        
    </ul>
</div>
<div id="bo_sch">
    <form>
        <select name="sfl" id="sfl" >
            <option value="wr_subject">제목</option>
            <option value="wr_content">내용</option>
            <option value="wr_subject||wr_content">제목+내용</option>
            <option value="mb_id,1">회원아이디</option>
            <option value="mb_id,0">회원아이디(코)</option>
            <option value="wr_name,1">글쓴이</option>
            <option value="wr_name,0">글쓴이(코)</option>
        </select>
        <input type="text" name="stx" value="" id="stx" class="frm_input" size="15">
        <input type="image" src="https://www.powerballgame.co.kr/images/btn_search_off.png" value="검색" class="btn_search">
    </form>
</div>
@endsection
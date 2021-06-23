

<?php $__env->startSection("content"); ?>
<div class="categoryTit">
    <ul>
      <li><a href="<?php echo e("board"); ?>?board_type=customer&board_category=notice" <?php if(Request::get("board_category") == "notice"): ?> class="on" <?php endif; ?>>공지사항</a></li>
      <li><a href="<?php echo e("board"); ?>?board_type=customer&board_category=event" <?php if(Request::get("board_category") == "event"): ?> class="on" <?php endif; ?>>이벤트</a></li>
      <li><a href="<?php echo e(route("prison")); ?>?page_type=prison" <?php if(Request::get("page_type") == "prison"): ?> class="on" <?php endif; ?>>정지</a></li>
    </ul>
</div>
<div class="prisonBox">
		<div class="content tbl_head01 tbl_wrap">
			<table class="table table-bordered mb-0">
				<colgroup>
					<col width="170">
					<col>
				</colgroup>
        <thead>
          <tr>
            <th>죄명</th>
            <th>사유</th>
          </tr>
        </thead>
				<tbody>
				<tr>
					<td class="tit">불법 사이트 홍보 및 유도</td>
					<td class="reason">사이트 내 불법 사이트, 타 사이트 홍보 및 유도하는 행위</td>
				</tr>
				<tr>
					<td class="tit">지속적인 운영정책 위반</td>
					<td class="reason">사이트 내 운영을 방해하는 행위</td>
				</tr>
				<tr>
					<td class="tit">운영진 비방</td>
					<td class="reason">운영진 및 운영정책, 사이트를 비방하는 행위</td>
				</tr>
				<tr>
					<td class="tit">개인정보 노출</td>
					<td class="reason">사이트 내 전화번호, 카톡, 계좌, 이메일, 메신저 등을 노출, 공유 하는 행위</td>
				</tr>
				<tr>
					<td class="tit">지속적인 비매너</td>
					<td class="reason">특정회원 비방, 부모 및 가족 관련 욕설, 성적 모욕을 하는 행위</td>
				</tr>
			</tbody>
    </table>

			<table class="table table-bordered">
				<colgroup>
					<col width="100">
					<col width="200">
					<col>
					<col width="150">
				</colgroup>
        <thead>
          <tr>
					<th>정지번호</th>
					<th>닉네임</th>
					<th>사유</th>
					<th>정지날자</th>
				</tr>
        </thead>
				<tbody>

			</tbody>
    </table>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/member/prison.blade.php ENDPATH**/ ?>
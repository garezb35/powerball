<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/dist/css/admin.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url(); ?>assets/js/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/ckeditor/sample.js"></script>
</head>
<body>
	<div class="pop-title"><h3>쪽지쓰기</h3></div>
	<div id="pop_wrap">
		<form method="post" name="popfrmMem" id="popfrmMem" action="/PopNote_I">
			<input type="hidden" name="mail_type"  value="2">
			<input type="hidden" name="fromId"  value="1">
			<input type="hidden" name="toId"  value="<?=$user->userId?>">
		    <table class="order_write order_table_top w-100">
		        <colgroup>
			        <col width="20%">
			        <col width="%">
		        </colgroup>
		        <tbody>
		        	<tr>
			            <th class="text-center">받는사람</th>
						<td ><?=$user->name?></td>
					</tr>
			        <tr>
			            <td colspan="2">
										<textarea class="contentInput" id="wr_content" name="content" required=""></textarea>
			            </td>
			        </tr>
			        <tr>
			        	<td class="text-center">
			        		<input type="submit" value="저장" class="btn btn-sm btn-primary">
			        		<a href="javascript:self.close();" class="btn btn-sm btn-secondary">닫기</a>
			        	</td>
			        </tr>
			    </tbody>
			</table>
		</form>
	</div>
</body>
</html>

<style>
.contentInput {
    width: 100%;
    height: 250px;
    overflow-y: scroll;
    background-color: #fff;
    overflow: auto;
    resize: none;
}
</style>

/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){

	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteUser",
			currentRow = $(this);
			alertify.prompt( '유저 사이트 이용정지', '정지이유', ''
	               , function(evt, value) {
									 jQuery.ajax({
								 			type : "POST",
								 			dataType : "json",
								 			url : hitURL,
								 			data : { userId : userId,reason:value }
								 			}).done(function(data){
								 				currentRow.parents('tr').remove();
								 				if(data.status = true) { alertify.success("성공적으로 중지되었습니다."); }
								 				else if(data.status = false) { alertify.error("요청이 실패되었습니다.");  }
								 				else { alertify.error("접근거절.");  }
						 			});
								  }
	               , function() { });
	});

	jQuery(document).on("click", ".deleteUserSure", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteUser",
			currentRow = $(this);

		var confirmation = confirm("Are you sure to delete this user ?");

		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId,sure:1 }
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});


	jQuery(document).on("click", ".ipblock", function(){
			var this_btn  = $(this)
			var userId = $(this).data("userid"),
			mode = $(this).data("mode"),
			ip = $(this).data("ip"),
			hitURL = baseURL + "ipblock",
			currentRow = $(this);
			if(mode == "disable"){
				alertify.prompt( '아이피 차단', '차단이유', ''
		               , function(evt, value) {
											 jQuery.ajax({
												 type : "POST",
												 dataType : "json",
												 url : hitURL,
												 data : { userId : userId,mode:mode,ip:ip,reason:value }
												 }).done(function(data){
													 if(data.status = true) { this_btn.text(data.txt) ;this_btn.data("mode",data.mode)}
													 else if(data.status = false) { alert("처리 오류"); }
													 else { alert("Access denied..!"); }
												 }).fail(function(xhr){
													 console.log(xhr)
										 });
									  }
		               , function() { });

			}
			else{
				jQuery.ajax({
					type : "POST",
					dataType : "json",
					url : hitURL,
					data : { userId : userId,mode:mode,ip:ip }
					}).done(function(data){
						if(data.status = true) { this_btn.text(data.txt) ;this_btn.data("mode",data.mode)}
						else if(data.status = false) { alert("처리 오류"); }
						else { alert("Access denied..!"); }
					}).fail(function(xhr){
						console.log(xhr)
				});
			}
	});

	jQuery(document).on("click", ".searchList", function(){

	});

});

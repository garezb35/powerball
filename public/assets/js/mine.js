$(document).ready(function(){
    $('#outIP').change(function() {
        $.ajax({
            type: "POST",
            url: "/api/setoutIP",
            data:{api_token:api_token,outip:$(this).prop('checked')}
        }).done(function(data) {
            alert("설정되었습니다.")
        });
    })
});

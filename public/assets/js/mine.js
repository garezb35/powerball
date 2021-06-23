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


function changeCountMine(type,content=""){
  var count = parseInt($("."+type+"-item").text());
  $("."+type+"-item").text(count-1);
  if(content !=""){
    $("."+type+"-msg").text(content)
  }
}

function changeCountItemToTop(count){
  $(top.document).find("#item-count").text(count)
}

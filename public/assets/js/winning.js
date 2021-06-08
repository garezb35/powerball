let powerball_list = new Array(),number_list = new Array();

$(document).ready(function(){
  getWiningMachine();
})

function getWiningMachine(){
  $.ajax({
      type: "POST",
      url: "/api/getWinningMachine",
      data:{api_token:api_token},
      dataType:"json"
  }).done(function(data) {
      if(data.status ==1){
        $(".pb_tbody").html("")
        $(".nb_tbody").html("")
        compileJson("#bar-info",".bar-header",data.total,1);
        compileJson("#winning-date",".pb_tbody",data.result.pb,2);
        compileJson("#winning-date",".nb_tbody",data.result.nb,2);
        heightResize();
      }
      else {
        alert(data.msg)
      }
  })
}

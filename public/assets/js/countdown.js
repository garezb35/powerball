$(document).ready(function(){
    // $.ajax({
    //     type: "get",
    //     url: "/api/synctime"
    // }).done(function(data) {
    //     if(data > 0){
    //         remainTime = getRemainTime(data);
    //         setInterval(function(){
    //             ladderTimer(300,'chatTimer');
    //         },1000);
    //     }
    // })
    var w = typeof winning != "undefined" && winning !=null ? winning : 0;
    setInterval(function(){
        ladderTimer(300,'chatTimer',w);
    },1000);
})

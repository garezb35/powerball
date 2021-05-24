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

    setInterval(function(){
        ladderTimer(300,'chatTimer');
    },1000);
})

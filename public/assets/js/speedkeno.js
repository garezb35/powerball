var pagination = 0;
var loading =false;
function toggleBetting()
{
    if($('.speed_iframe').css('display') == 'block')
    {
        $('.speed_iframe').hide();
        $('#pointBetBtn').attr('src',$('#pointBetBtn').attr('src').replace('_close.png','_open.png'));
    }
    else
    {
        $('.speed_iframe').show();
        $('#pointBetBtn').attr('src',$('#pointBetBtn').attr('src').replace('_open.png','_close.png'));
    }
}
function moreClick()
{
    if(loading == false)
    {
        loading = true;
        $('#pageDiv').show();
        var page = parseInt($('#pageDiv').attr('pageVal')) + 1;

        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/api/get_more/speedkeno',
            data:{skip:pagination},
            beforeSend: function() {
                moreLoad(1)
            },
            success:function(data,textStatus){
                if(data.status == 1){
                    pagination = pagination + 30;
                    compileJson("#see-data",".see-t",data.result,2);
                }
            }
        }).done(function(data){
            moreLoad(0)
            loading = false;
            if(data.status == 0)
                loading  = true;
        })
    }
}

$(document).ready(function() {
    moreClick();
});


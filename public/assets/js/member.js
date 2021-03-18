$(document).ready(function(){
    $('.box-level').find('li').mouseenter(function(){
        $(this).find('.text').show().closest('li').siblings().find('.text').hide();
    });
    $('.box-level').mouseleave(function(){
        $(this).find('li.on').find('.text').show().closest('li').siblings().find(".text").hide();
    });
});

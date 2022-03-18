$(function(){
			
    $(window).scroll(function() {
        
        $('#top').css('top' , ($(this).scrollTop()));
        $('#left').css('left',($(this).scrollLeft()));

        $('span').css('top' , ($(this).scrollTop()));
        
        $('span').css('left',($(this).scrollLeft()));

        
    });
});
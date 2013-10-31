$('.thumbnail').hover(
    function () {
        $(this).find('.caption-btm').show(250);
    },
    
    function () {
        $(this).find('.caption-btm').hide(250);
    });
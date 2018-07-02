$('footer a').on('click',function(evt){
    Cookies.set('language', $(this).find('span').attr('data-value'));
    location.reload();
});

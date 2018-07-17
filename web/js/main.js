if (Cookies.get('language') == undefined) {
    Cookies.set('language', 'en-US',{expires:10000});
}

$('footer a').on('click',function (evt) {
    Cookies.set('language', $(this).find('span').attr('data-value'),{expires:10000});
    location.reload();
});

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

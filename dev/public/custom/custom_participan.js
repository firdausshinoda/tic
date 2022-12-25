moment.locale('en');
$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
    getNotif();
    setInterval(function () {getNotif()}, 10000);
});
function setAktifItem(id) {
    if (id==="dashboard"){$('.components #i_dashboard').addClass('active');}
    else if (id==="notification"){$('.components #i_notification').addClass('active');}
    else if (id==="payment"){$('.components #i_payment').addClass('active');}
    else if (id==="journal"){$('.components #i_journal').addClass('active');}
    else if (id==="videos"){$('.components #i_videos').addClass('active');}

    if (id==="journal" || id==="video"){
        $('#form-search').show();
        $('#form-input-search').val('');
    } else {
        $('#form-search').hide();
        $('#form-input-search').val('');
    }
}

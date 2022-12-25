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
    else if (id==="payment_journal"){$('#i_payment, #i_payment_journal').addClass('active');$('#subPayment').addClass('show');}
    else if (id==="payment_participan"){$('#i_payment, #i_payment_participan').addClass('active');$('#subPayment').addClass('show');}
    else if (id==="journal"){$('#i_journal, #i_journal_journal').addClass('active');$('#subJournal').addClass('show');}
    else if (id==="journal_process"){$('#i_journal, #i_journal_process').addClass('active');$('#subJournal').addClass('show');}
    else if (id==="journal_confirmation"){$('#i_journal, #i_journal_confirm').addClass('active');$('#subJournal').addClass('show');}
    else if (id==="journal_draft"){$('#i_journal, #i_journal_draft').addClass('active');$('#subJournal').addClass('show');}
    else if (id==="revision"){$('.components #i_revision').addClass('active');}
    else if (id==="videos"){$('.components #i_videos').addClass('active');}
    else if (id==="authors"){$('#i_users, #i_users_authors').addClass('active');$('#subUsers').addClass('show');}
    else if (id==="reviewers"){$('#i_users, #i_users_reviewer').addClass('active');$('#subUsers').addClass('show');}
    else if (id==="participan"){$('#i_users, #i_users_participan').addClass('active');$('#subUsers').addClass('show');}
    else if (id==="country"){$('#i_document, #i_document_country').addClass('active');$('#subDocument').addClass('show');}
    else if (id==="degree"){$('#i_document, #i_document_degree').addClass('active');$('#subDocument').addClass('show');}
    else if (id==="sosmed"){$('#i_document, #i_document_sosmed').addClass('active');$('#subDocument').addClass('show');}
    else if (id==="contact"){$('#i_document, #i_document_contact').addClass('active');$('#subDocument').addClass('show');}
    else if (id==="events"){$('.components #i_events').addClass('active');}

    if (id==="journal"){
        $('#form-search').show();
        $('#form-input-search').val('');
    } else {
        $('#form-search').hide();
        $('#form-input-search').val('');
    }
}

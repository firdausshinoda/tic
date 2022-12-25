$(window).on('scroll', function () {
    if ( $(window).scrollTop() > 10 ) {
        $('.navbar').addClass('navbar-active');
    } else {
        $('.navbar').removeClass('navbar-active');
    }
});
const swalWithBootstrapButtons = Swal.mixin({
    customClass: {confirmButton: 'btn btn-success m-1', cancelButton: 'btn btn-danger m-1'},
    buttonsStyling: false
});
function swall_success(){
    swalWithBootstrapButtons.fire({icon: 'success', title: '', text: 'Berhasil Melakukan Registrasi. Silahkan Cek E-mail Anda.'});
}
function swall_error(){
    swalWithBootstrapButtons.fire({icon: 'error', title: 'Oops...', text: 'There is an error. Please try again!!! '});
}

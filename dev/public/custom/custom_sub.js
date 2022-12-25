const $dropdown = $(".dropdown");
const $dropdownToggle = $(".dropdown-toggle");
const $dropdownMenu = $(".dropdown-menu");
const showClass = "show";
$(window).on("load resize", function() {
    if (this.matchMedia("(min-width: 768px)").matches) {
        $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "true");
                $this.find($dropdownMenu).addClass(showClass);
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
        );
    } else {
        $dropdown.off("mouseenter mouseleave");
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
function setEmbed(link_video){
    var link_embed = null;
    if (link_video.includes("https://www.youtube.com/watch?v=")){
        var substr = "https://www.youtube.com/watch?v=";
        link_embed = link_video.slice(link_video.indexOf(substr) + substr.length, link_video.length);
    } else {
        var substr = "https://youtu.be/";
        link_embed = link_video.slice(link_video.indexOf(substr) + substr.length, link_video.length);
    }
    return 'https://www.youtube.com/embed/'+link_embed;
}

var hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jum&#39;at','Sabtu'];
var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {vars[key] = value;});
    return vars;
}
function stripTags(original) {
    if (original === ""||original === null){
        return "";
    }
    let parsed = new DOMParser().parseFromString(original, 'text/html');
    return parsed.body.textContent;
}
function setTgl(str){
    var __tgl = new Date(str);
    var __hari = __tgl.getDay();
    var __bulan = __tgl.getMonth();
    var __tahun = __tgl.getYear();
    var tahun__ = (__tahun<1000)?__tahun+1900 : __tahun;
    return hari[__hari]+', '+__tgl.getDate()+' '+bulan[__bulan]+' '+tahun__;
}
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}
function convertToRupiah(angka){
    var number_string = angka.toString().replace(/[^,\d]/g, ''),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    return split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
}
function Comma(Num) {
    Num += '';
    Num = Num.replace('.', ''); Num = Num.replace('.', ''); Num = Num.replace('.', '');
    Num = Num.replace('.', ''); Num = Num.replace('.', ''); Num = Num.replace('.', '');
    x = Num.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    return x1 + x2;
}
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
function swall_success_reload(){
    swalWithBootstrapButtons.fire({title: 'Berhasil.', text: "", icon: 'success',}).then((result) => {
        if (result.value) {location.reload();}
    });
}
function swall_success_back(){
    swalWithBootstrapButtons.fire({title: 'Berhasil.', text: "", icon: 'success',}).then((result) => {
        if (result.value) {history.back();}
    });
}
function swall_failed_add(){
    swalWithBootstrapButtons.fire({icon: 'error', title: 'Oops...', text: 'Failed to Add Data!!! '});
}
function swall_failed_delete(){
    swalWithBootstrapButtons.fire({icon: 'error', title: 'Oops...', text: 'Gagal Menghapus Data!!!'});
}
function swall_failed_edit(){
    swalWithBootstrapButtons.fire({icon: 'error', title: 'Oops...', text: 'Gagal Mengubah Data!!!'});
}
function swall_failed_text(str){
    swalWithBootstrapButtons.fire({icon: 'error', title: 'Oops...', text: str});
}
function swall_error(){
    swalWithBootstrapButtons.fire({icon: 'error', title: 'Oops...', text: 'There is an error. Please try again!!! '});
}
function loader_show(){
    $('#progressBar-indeterminate').css("visibility", "visible");
}
function loader_hide(){
    $('#progressBar-indeterminate').css("visibility", "hidden");
}
function loader_show_upload(){
    $('#progressBar-determinate').css("visibility", "visible");
}
function loader_hide_upload(){
    $('#progressBar-determinate').css("visibility", "hidden");
}
function setName_author(str1,str2,str3) {
    var coressponden_author = "";
    if (str1 !== null){
        coressponden_author += str1;
    }
    if (str2 !== null){
        coressponden_author += ' '+str2;
    }
    if (str3 !== null){
        coressponden_author += ' '+str3;
    }
    return coressponden_author;
}
function checkNull(str, stt = false) {
    if (str !== null){
        return str;
    } else {
        if (stt) {
            return "";
        } else {
            return "-";
        }
    }
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

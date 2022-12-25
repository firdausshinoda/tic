<?php


namespace App\Helpers;


class Helpers
{
    public static function getRandomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    public static function time_ago_en($datetime){
        $selisih = time() - strtotime($datetime);
        $detik = $selisih;
        $menit = round($selisih / 60);
        $jam = round($selisih / 3600);
        $hari = round($selisih / 86400);
        $minggu = round($selisih / 604800);
        $bulan = round($selisih / 2419200);
        $tahun = round($selisih / 29030400);
        global $waktu_lalu;
        $waktu_jam = substr($waktu_lalu, 11, 5);
        if ($detik <= 30) {$waktu = ' baru saja';}
        elseif ($detik <= 60) {$waktu = $detik . ' detik yang lalu';}
        elseif ($menit <= 60) {$waktu = $menit . ' menit yang lalu';}
        elseif ($jam <= 24) {$waktu = $jam . ' jam yang lalu';}
        elseif ($hari <= 1) {$waktu = ' kemarin ' . $waktu_jam;}
        elseif ($hari <= 7) {$waktu = $hari . ' hari yang lalu ' . $waktu_jam;}
        elseif ($minggu <= 4) {$waktu = $minggu . ' minggu yang lalu ' . $waktu_jam;}
        elseif ($bulan <= 12) {$waktu = $bulan . ' bulan yang lalu ' . $waktu_jam;}
        else {$waktu = $tahun . ' tahun yang lalu ' . $waktu_jam;}
        return $waktu;
    }
    public static function enkrip($string)
    {
        $bumbu = md5(str_replace("=", "", base64_encode("poltektegal.com")));
        $metodeenkrip = "AES-256-CBC";
        $kunci = hash('sha256', $bumbu);
        $kodeiv = substr(hash('sha256', $bumbu), 0, 16);
        $katakata = str_replace("=", "", openssl_encrypt($string, $metodeenkrip, $kunci, 0, $kodeiv));
        return str_replace("=", "", base64_encode($katakata));
    }
    public static function dekrip($string)
    {
        $bumbu = md5(str_replace("=", "", base64_encode("poltektegal.com")));
        $metodeenkrip = "AES-256-CBC";
        $kunci = hash('sha256', $bumbu);
        $kodeiv = substr(hash('sha256', $bumbu), 0, 16);
        return openssl_decrypt(base64_decode($string), $metodeenkrip, $kunci, 0, $kodeiv);
    }
    public static function base64_encode_image($path) {
        // $type = pathinfo($path, PATHINFO_EXTENSION);
        // $data = file_get_contents($path);
        // return 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $path;
    }
    public static function setTglSurat($cdate)
    {
        $bulan = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $wkt_indo = strtotime($cdate);
        return date("j", $wkt_indo) . " " . $bulan[date("n", $wkt_indo)] . " " . date("Y", $wkt_indo);
    }
    public static function setTglSuratFormal($cdate)
    {
        $bulan = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $hari=array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
        $wkt_indo = strtotime($cdate);
        return $hari[date("w",$wkt_indo)]."/".$bulan[date("n",$wkt_indo)]." ".date("j",$wkt_indo).", ".date("Y",$wkt_indo);
    }
}

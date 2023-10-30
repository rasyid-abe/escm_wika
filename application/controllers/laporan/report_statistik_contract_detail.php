<?php 
$view = 'laporan/report_statistik_contract_detail_v';
$data = array(
    'total' => 1,
    'kode' => $kode
);
switch ($kode) {
    case 'aktif':
        $nama = '(Aktif)';
        break;

    case 'batal':
        $nama = '(Dibatalkan)';
        break;

    case 'selesai':
        $nama = '(Selesai)';
        break;

    case 'expired':
        $nama = '(Expired)';
        break;

    case '3bln':
        $nama = '(Expire < 3 Bulan)';
        break;

    case '1bln':
        $nama = '(Expire < 1 Bulan)';
        break;
    
    default:
        $nama = '';
        break;
}
$this->template($view,"Rekap Statistik Kontrak Detail ".$nama,$data);
?>
<?php
session_start();

if ($_SESSION['password'] == '') {
    header("location:login.php");
    exit();
}

include 'koneksi.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_kerusakan_barang_lab_rpl.xls");
header("Cache-Control: max-age=0");

ob_start();

echo '<html>';
echo '<head>';
echo '<meta charset="utf-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<style>';
echo 'table { width: 100%; border-collapse: collapse; }';
echo 'th, td { border: 1px solid black; padding: 5px; text-align: center; }';
echo '</style>';
echo '</head>';
echo '<body>';
echo '<table>';
echo '<thead>';
echo '<tr>';
echo '<th rowspan="2">NO</th>';
echo '<th rowspan="2">KODE KOMPUTER</th>';
echo '<th rowspan="2">TAHUN KOMPUTER</th>';
echo '<th colspan="6">RINCIAN KERUSAKAN</th>';
echo '<th rowspan="2">KETERANGAN</th>';
echo '<th rowspan="2">PIC PENGECEKAN</th>';
echo '</tr>';
echo '<tr>';
echo '<th>TANGGAL KERUSAKAN</th>';
echo '<th>TANGGAL PENGECEKAN</th>';
echo '<th>PERANGKAT YANG RUSAK</th>';
echo '<th>REKOMENDASI & PERBAIKAN</th>';
echo '<th>KONDISI SAAT INI</th>';
echo '<th>PERANGKAT YANG TIDAK RUSAK</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

$ret = mysqli_query($conn, "SELECT * FROM barang_rusak");
$no = 1;
while ($isi = mysqli_fetch_array($ret)) {
    echo '<tr>';
    echo '<td>' . $no++ . '</td>';
    echo '<td>' . htmlspecialchars($isi['kode_komputer'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($isi['tahun_komputer'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($isi['tanggal_kerusakan'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($isi['tanggal_pengecekan'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($isi['perangkat_yang_rusak'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($isi['rekomendasi_perbaikan'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($isi['kondisi_saat_ini'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($isi['perangkat_tidak_rusak'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($isi['keterangan'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($isi['pic_pengecekan'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
echo '</body>';
echo '</html>';

ob_end_flush();
?>

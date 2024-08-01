<?php
session_start();

if ($_SESSION['password'] == '') {
    header("location:login.php");
    exit();
}

include 'koneksi.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_data_barang_lab_rpl.xls");
header("Cache-Control: max-age=0");

ob_start();

echo '<html>';
echo '<head>';
echo '<meta charset="utf-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<style>';
echo 'table { width: 100%; border-collapse: collapse; }';
echo 'th, td { border: 1px solid black; padding: 5px; text-align: center; vertical-align: middle;} ';
echo '</style>';
echo '</head>';
echo '<body>';
echo '<table>';
echo '<thead>';
echo '<tr>';
echo '<th>No</th>';
echo '<th>Gambar Barang</th>';
echo '<th>Nama Barang</th>';
echo '<th>Jenis Barang</th>';
echo '<th>Jumlah Barang</th>';
echo '<th>Kondisi Barang</th>';
echo '<th>Deskripsi Barang</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

$ret = mysqli_query($conn, "SELECT * FROM masuk");
$no = 1;
while ($isi = mysqli_fetch_array($ret)) {
    echo '<tr>';
    echo '<td>' . $no++ . '</td>';
    echo '<td style="height:130px;"><img style="padding: 5px; text-align: center; vertical-align: middle;" src="http://localhost/inventaris_lab_rpl/admin/' . htmlspecialchars($isi['path_gambar'], ENT_QUOTES, 'UTF-8') . '" width="100" height="100" /></td>';
    echo '<td>' . htmlspecialchars($isi['nama'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($isi['jenis'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($isi['jumlah'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($isi['kondisi'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($isi['deskripsi'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
echo '</body>';
echo '</html>';

ob_end_flush();
?>

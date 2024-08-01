<?php
include 'koneksi.php';
$delete = mysqli_query($conn, "DELETE FROM barang_rusak WHERE id = '".$_GET['id']."'");
$query = mysqli_query($conn, "SELECT * FROM barang_rusak ORDER BY id");
$hasil = ($query);
$no = 1;
while ($data  = mysqli_fetch_array($hasil)){
   $id = $data['id'];
   $query2 = mysqli_query($conn, "UPDATE barang_rusak SET id = $no WHERE id = $id");
   $no++;
}
$query = mysqli_query($conn, "ALTER TABLE barang_rusak AUTO_INCREMENT = $no");
if($delete){
   header('location: lapor.php');
}
else{
   echo "Gagal";
}
?>

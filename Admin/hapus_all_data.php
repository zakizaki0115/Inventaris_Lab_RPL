<?php
include 'koneksi.php';
$delete = mysqli_query($conn, "DELETE FROM masuk");
$query = mysqli_query($conn, "SELECT * FROM masuk ORDER BY id");
$hasil = ($query);
$no = 1;
while ($data  = mysqli_fetch_array($hasil)){
  $id = $data['id'];
  $query2 = mysqli_query($conn, "UPDATE masuk SET id = $no WHERE id = $id");
  $no++;
}
$query = mysqli_query($conn, "ALTER TABLE masuk  AUTO_INCREMENT = $no");
$hasil = ($query);
$no = 1;
if($delete){
  header('location: data.php');
}else{
  echo "Gagal";
}
?>
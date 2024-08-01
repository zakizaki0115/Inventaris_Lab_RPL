<?php
$cari=$_GET['cari'];
header("location:data.php?cari=$cari");
?>
<?php
session_start();
if (empty($_SESSION['password'])) {
  header("Location: login.php");
  exit();
}
include 'koneksi.php';
error_reporting(0);
?>

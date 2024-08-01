<?php
session_start();
if($_SESSION['password']=='')
{
  header("location:login.php");
}
include 'koneksi.php';
error_reporting(0);
$nama = mysqli_query($conn, "select * from about");
$profile = mysqli_fetch_array($nama);
$sss = mysqli_query($conn, "select * from admin");
$rrr = mysqli_fetch_array($sss);
ob_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Ganti Password - Inventaris Lab RPL</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
  <div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-text">Inventaris Lab RPL</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="data.php">
          <i class="fas fa-fw fa-box"></i>
          <span>Data Barang</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="lapor.php">
          <i class="fas fa-fw fa-exclamation"></i>
          <span>Lapor Kerusakan</span>
        </a>
      </li>
      <hr class="sidebar-divider d-none d-md-block">
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle pl-0" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-3 d-none d-lg-inline text-gray-600 small"><b><?php echo $profile['nama'] ?></b></span>
                <img class="img-profile rounded-circle" src=" penampung/<?php echo$profile['foto'] ?>" alt="Profile"  width="100px" height="100px">
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profil
                </a>
                <a class="dropdown-item" href="setting.php?id=<?php echo $profile['id']; ?>">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Pengaturan
                </a>
                <a class="dropdown-item" href="change.php?id=<?php echo $rrr['id']; ?>">
                  <i class="fas fa-ruler-horizontal fa-sm fa-fw mr-2 text-gray-400"></i>
                  Ganti Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <?php
        $id_brg= ($_GET['id']);
        $id_pesan= ($_GET['pesan']);
        $ggl = !$id_brg;
        $dgi = !$id_pesan;
        if($ggl and $dgi){
          echo "<div class='col-md-10 col-sm-12 col-xs-12 ml-5 mt-5'>";
          echo "<div class='alert alert-danger ml-5' role='alert'>";
          echo "<p><center>Maaf Data Ini Tidak Tersedia</center></p>";
          echo   "</div>";
          echo "</div>";
        }else{
          $sg=mysqli_query($conn, "select * from admin where id='$id_brg'");
          while($sw=mysqli_fetch_array($sg)){
        ?>
        <div class="card shadow  ml-4 mr-4">
          <div class="card-header py-3">
          <h1 class="h3 mb-0 text-gray-800"><b>Ubah Password</b></h1>
          </div>
          <form action="change_pass.php" method="post">
            <div class="row ml-5 mb-2 mt-3">
              <div class="col-md-6">
                <input class="form-control" type="hidden" name='username'  value="<?php echo $sw['username']; ?>" required>
                <p class="m-0">
                  <b>Password Lama</b>
                </p>
                <input class="form-control mb-3" type="password" name='pertama'  placeholder="Password Lama..." required>
                <p class="m-0">
                  <b>Password Baru</b>
                </p>
                <input class="form-control mb-3" type="password" name='kedua' value="" placeholder="Password Baru..." required>
                <p class="m-0">
                  <b>Ulangi Password Baru</b>
                </p>
                <input class="form-control" type="password" name='ketiga' value="" placeholder="Password Baru..." required>
              </div>
            </div>
            <div class="row ml-5 mb-3 mt-3">
              <div class="col-md-5">
                <button type="submit" class="btn btn-info" name='edit'>Update</button>&nbsp;
                <input type="reset" class="btn btn-danger"  value="Reset">
              </div>
            </div>
          </form>
        </div>
        <?php }} ?>
        <?php
        if(isset($_GET['pesan'])){
          $pesan= addslashes($_GET['pesan']);
          if($pesan=="gagal"){
            echo "<div class='col-md-10 col-sm-12 col-xs-12 ml-5'>";
            echo "<div class='alert alert-danger ml-5' role='alert'>";
            echo "<p><center>Gagal Mengganti Password</center></p>";
            echo "</div>";
            echo "</div>";
          }else if($pesan=="tdksama"){
            echo "<div class='col-md-10 col-sm-12 col-xs-12 ml-5'>";
            echo "<div class='alert alert-warning mt-4 ml-5' role='alert'>";
            echo "<p><center>Password Yang Anda Masukan Tidak Sama</center></p>";
            echo "</div>";
            echo "</div>";
          }else if($pesan=="oke"){
            echo "<div class='col-md-10 col-sm-12 col-xs-12 ml-5'>";
            echo "<div class='alert alert-primary mt-4 ml-5' role='alert'>";
            echo "<p><center>Mengganti Password Sukses</center></p>";
            echo "</div>";
            echo "</div>";
          }
        } 
        ?>
      </div>
      <footer class="sticky-footer bg-white">
        <div class="container my-auto"></div>
      </footer>
    </div>
  </div>
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><b>Peringatan</b></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          Yakin ingin logout?
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <a class="btn btn-danger" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
</body>
</html>
<?php ob_end_flush() ?>
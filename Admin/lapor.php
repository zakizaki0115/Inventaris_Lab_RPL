<?php
session_start();
if (empty($_SESSION['password'])) {
  header("Location: login.php");
  exit();
}
include 'koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Lapor Kerusakan - Inventaris Lab RPL</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> 
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <style>
    .jarak{
      margin-left: 225px;
      padding-right: 250px;
    }
  </style>
</head>
<body id="page-top">
  <div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion fixed-top" id="accordionSidebar">
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
      <li class="nav-item active">
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
            <?php
            $nama = mysqli_query($conn, "SELECT * FROM about");
            $profile = mysqli_fetch_array($nama);
            ?>
            <div class="topbar-divider d-none d-sm-block"></div>
            <?php
            $sss = mysqli_query($conn, "SELECT * FROM admin");
            $rrr = mysqli_fetch_array($sss);
            ?>
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
        <div class="container-fluid hidden jarak">
        <?php
        if (isset($_POST['kirim'])) {
            $kode_komputer = mysqli_real_escape_string($conn, $_POST['kode_komputer']);
            $tahun_komputer = mysqli_real_escape_string($conn, $_POST['tahun_komputer']);
            $tanggal_kerusakan = $_POST['kerusakan_komputer'];
            $tanggal_pengecekan = $_POST['pengecekan_komputer'];
            $kerusakan = date("Y-m-d", strtotime($tanggal_kerusakan));
            $pengecekan = date("Y-m-d", strtotime($tanggal_pengecekan));
            $perangkat_yang_rusak = mysqli_real_escape_string($conn, $_POST['perangkat_rusak']);
            $rekomendasi_perbaikan = mysqli_real_escape_string($conn, $_POST['rekomendasi_perbaikan']);
            $kondisi_saat_ini = mysqli_real_escape_string($conn, $_POST['kondisi_komputer']);
            $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan_komputer']);
            $perangkat_tidak_rusak = mysqli_real_escape_string($conn, $_POST['perangkat_tidak_rusak']);
            $pic_pengecekan = mysqli_real_escape_string($conn, $_POST['pic_pengecekan']);

            $wet = mysqli_query($conn, "SELECT * FROM barang_rusak WHERE kode_komputer='$kode_komputer' AND tahun_komputer='$tahun_komputer' AND tanggal_kerusakan='$kerusakan' AND tanggal_pengecekan='$pengecekan' AND perangkat_yang_rusak='$perangkat_yang_rusak' AND rekomendasi_perbaikan='$rekomendasi_perbaikan' AND kondisi_saat_ini='$kondisi_saat_ini' AND keterangan='$keterangan' AND perangkat_tidak_rusak='$perangkat_tidak_rusak' AND pic_pengecekan='$pic_pengecekan'");
            $chak = mysqli_num_rows($wet);

            if ($chak > 0) {
                echo "<div class='col-md-10 col-sm-12 col-xs-12 ml-5'>";
                echo "<div class='alert alert-warning mt-4 ml-5' role='alert'>";
                echo "<p><center>Data yang Anda kirim sudah tersedia</center></p>";
                echo "</div>";
                echo "</div>";
            } else {
                $insert = mysqli_query($conn, "INSERT INTO barang_rusak (kode_komputer, tahun_komputer, tanggal_kerusakan, tanggal_pengecekan, perangkat_yang_rusak, rekomendasi_perbaikan, kondisi_saat_ini, keterangan, perangkat_tidak_rusak, pic_pengecekan) VALUES ('$kode_komputer', '$tahun_komputer', '$kerusakan', '$pengecekan', '$perangkat_yang_rusak', '$rekomendasi_perbaikan', '$kondisi_saat_ini', '$keterangan', '$perangkat_tidak_rusak', '$pic_pengecekan')");
                if ($insert) {
                    echo "<div class='col-md-10 col-sm-12 col-xs-12 ml-5'>";
                    echo "<div class='alert alert-primary mt-4 ml-5' role='alert'>";
                    echo "<p><center>Menambahkan data sukses</center></p>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "<div class='col-md-10 col-sm-12 col-xs-12 ml-5'>";
                    echo "<div class='alert alert-danger ml-5' role='alert'>";
                    echo "<p><center>Menambahkan data gagal</center></p>";
                    echo "</div>";
                    echo "</div>";
                    echo "Error: " . mysqli_error($conn);
                }
            }
        }
        ?>
        <div class="row">
          <div class="col-md-8 mt-2 mb-3">
            <h2><b><center>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Lapor Kerusakan Barang Lab RPL</center></b></h2>
          </div>
        </div>
        <div class="card shadow  ml-4 mr-4">
          <div class="card-header py-3">
            <div class="row">
              <div class="col-md-7">
                <h6 class="mt-1 font-weight-bold text-primary">Lapor Kerusakan Barang</h6>
              </div>
              <div class="col justify-content-end"></div>
              <div class="pl-5 mr-2">
              <?php
                $cep = mysqli_query($conn, "SELECT * FROM barang_rusak");
                $tesd= mysqli_num_rows($cep);
                if($tesd > 0 ){
                  echo "<form name='hapus' method='post'>";
                  echo "<button type='button' class='d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm' data-toggle='modal' data-target='#hapusSemuaL'><i class='fas fa-solid fa-trash fa-sm text-white mr-2'></i>Hapus Semua<i class='fas fa-solid fa-trash fa-sm text-white ml-2'></i></button>";
                  echo "</form>";
                }else{
                }
              ?>
              </div>
              <div class="mr-2">
              <?php
                $cep = mysqli_query($conn, "SELECT * FROM barang_rusak");
                $tesd= mysqli_num_rows($cep);
                if($tesd > 0 ){
                  echo "<a href='export_excel_laporan.php' class='d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm'>";
                  echo "<i class='fas fa-download fa-sm text-white mr-1'></i>";
                  echo "Cetak Excel";
                  echo "</a>";
                }else{
                }
              ?>
              </div>
              <div class="mr-1">
                <button type="button" data-toggle="modal" data-target="#tambahLaporan" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                  <i class="fas fa-plus fa-sm text-white mr-1"></i>
                  Tambah Laporan
                </button>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <p class="ml-4 mt-4">
                <?php
                $jumlahh = mysqli_query($conn, "SELECT COUNT(id) as jumlah FROM barang_rusak");
                $totalJ =mysqli_fetch_array($jumlahh);
                echo "Total Laporan: &nbsp<b>". number_format($totalJ['jumlah'])." laporan</b>"; 
                ?>
              </p>
            </div>
            <div class="col-md-4 mt-4 mb-4">
              <form class="form-inline my-2 my-lg-0" action="cari_laporan.php" method="get" name="cari" onsubmit="return validateForm()">
                <input class="form-control mr-sm-2" type="search" placeholder="Cari" aria-label="Cari" name='cari' value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
              </form>
            </div>
          </div>
          <?php
          $per_page = 10;
          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
          $start = ($page - 1) * $per_page;
          $total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM barang_rusak");
          $total_data = mysqli_fetch_assoc($total_query)['total'];
          $total_pages = ceil($total_data / $per_page);
          ?>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive service">
              <table class="table table-bordered table-hover  mt-0 text-nowrap css-serial">
                <thead>
                  <tr>
                    <th scope="col" width="3%">No</th>
                    <th scope="col" width="10%">Kode Komputer</th>
                    <th scope="col" width="15%">Tahun Komputer</th>
                    <th scope="col" width="15%">Tanggal Kerusakan</th>
                    <th scope="col" width="5%">Tanggal Pengecekan</th>
                    <th scope="col" width="12%">Perangkat yang Rusak</th>
                    <th scope="col">Rekomendasi & Perbaikan</th>
                    <th scope="col">Kondisi Saat Ini</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Perangkat Tidak Rusak</th>
                    <th scope="col">PIC Pengecekan</th>
                    <th scope="col" width="6%">Opsi</th>
                  </tr>
                </thead>
                <?php
                if(isset($_GET['cari']) && !empty($_GET['cari'])){
                  $cari = mysqli_real_escape_string($conn, $_GET['cari']);
                  $_SESSION['cari'] = $cari;
                  $brg = mysqli_query($conn, "SELECT * FROM barang_rusak WHERE id LIKE '%".$cari."%' OR kode_komputer LIKE '%".$cari."%' OR tahun_komputer LIKE '%".$cari."%' OR tanggal_kerusakan LIKE '%".$cari."%' OR tanggal_pengecekan LIKE '%".$cari."%' OR perangkat_yang_rusak LIKE '%".$cari."%' OR rekomendasi_perbaikan LIKE '%".$cari."%' OR kondisi_saat_ini LIKE '%".$cari."%' OR keterangan LIKE '%".$cari."%' OR perangkat_tidak_rusak LIKE '%".$cari."%' OR pic_pengecekan LIKE '%".$cari."%'");
                  if(mysqli_num_rows($brg) > 0){
                    // Hasil pencarian ditemukan
                  } else {
                    echo "<div class='col-md-10 col-sm-12 col-xs-12 ml-5'>";
                    echo "<div class='alert alert-danger ml-5' role='alert'>";
                    echo "<p><center>Data $cari yang Anda cari tidak ditemukan</center></p>";
                    echo "</div>";
                    echo "</div>";
                  }
                } else {
                  $_SESSION['cari'] = isset($_SESSION['cari']) ? $_SESSION['cari'] : '';
                  $query = "SELECT * FROM barang_rusak LIMIT $start, $per_page";
                  $brg = mysqli_query($conn, $query);
                }
                if(mysqli_num_rows($brg) > 0){
                  $no = $start + 1;
                  while($row = mysqli_fetch_assoc($brg)){                
                ?>
                <tbody>
                  <tr class="text-wrap">
                    <th scope="row"><?php echo $row['id'] ?></th>
                    <td><?php echo $row['kode_komputer'] ?></td>
                    <td><?php echo $row['tahun_komputer'] ?></td>
                    <td><?php echo $row['tanggal_kerusakan'] ?></td>
                    <td><?php echo $row['tanggal_pengecekan'] ?></td>
                    <td><?php echo $row['perangkat_yang_rusak'] ?></td>
                    <td><?php echo $row['rekomendasi_perbaikan'] ?></td>
                    <td><?php echo $row['kondisi_saat_ini'] ?></td>
                    <td><?php echo $row['keterangan'] ?></td>
                    <td><?php echo $row['perangkat_tidak_rusak'] ?></td>
                    <td><?php echo $row['pic_pengecekan'] ?></td>
                    <td class="p-2 align-content-center">
                      <div class="col d-flex justify-content-center">
                        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-warning" style="width:32px" data-toggle="modal" data-target="#editData<?php echo $row['id']; ?>"><i class="fas fa-solid fa-pen fa-sm text-white"></i></button>
                      </div>
                      <div class="col mt-2 d-flex justify-content-center">
                        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-info" style="width:32px" data-toggle="modal" data-target="#detailData<?php echo $row['id']; ?>"><i class="fas fa-solid fa-info fa-sm text-white"></i></button>
                      </div>
                      <div class="col mt-2 d-flex justify-content-center">
                        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-danger" style="width:32px" data-toggle="modal" data-target="#hapusData<?php echo $row['id']; ?>"><i class="fas fa-solid fa-trash fa-sm text-white"></i></button>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <div class="modal fade" id="hapusData<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="hapusDataLabel<?php echo $row['id']; ?>" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title fs-5" id="hapusDataLabel<?php echo $row['id']; ?>">
                          <b>Peringatan</b>
                        </h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Yakin ingin menghapus data?
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <a href="hapus_laporan.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Hapus</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="editData<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editDataLabel<?php echo $row['id']; ?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="editDataLabel<?php echo $row['id']; ?>">
                          <b>Edit Data</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form name="edit" method="post">
                          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="kode_komputer"><b>Kode Komputer</b></label>
                                <input type="text" class="form-control" id="kode_komputer" name="kode_komputer" value="<?php echo htmlspecialchars($row['kode_komputer']); ?>" required>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="tahun_komputer"><b>Tahun Komputer</b></label>
                                <input type="text" class="form-control" id="tahun_komputer" name="tahun_komputer" value="<?php echo htmlspecialchars($row['tahun_komputer']); ?>" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="tanggal_kerusakan"><b>Tanggal Kerusakan</b></label>
                                <input type="date" class="form-control" id="tanggal_kerusakan" name="tanggal_kerusakan" value="<?php echo htmlspecialchars($row['tanggal_kerusakan']); ?>" required>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="tanggal_pengecekan"><b>Tanggal Pengecekan</b></label>
                                <input type="date" class="form-control" id="tanggal_pengecekan" name="tanggal_pengecekan" value="<?php echo htmlspecialchars($row['tanggal_pengecekan']); ?>" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="perangkat_yang_rusak"><b>Perangkat yang Rusak</b></label>
                                <input type="text" class="form-control" id="perangkat_yang_rusak" name="perangkat_yang_rusak" value="<?php echo htmlspecialchars($row['perangkat_yang_rusak']); ?>" required>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="rekomendasi_perbaikan"><b>Rekomendasi & Perbaikan</b></label>
                                <input type="text" class="form-control" id="rekomendasi_perbaikan" name="rekomendasi_perbaikan" value="<?php echo htmlspecialchars($row['rekomendasi_perbaikan']); ?>" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="kondisi"><b>Kondisi Komputer</b></label>
                                <select name="kondisi" id="kondisi" class="form-control" required>
                                  <option value="PC dapat digunakan" <?php if($row['kondisi_saat_ini'] == 'PC dapat digunakan') echo 'selected'; ?>>PC dapat digunakan</option>
                                  <option value="PC tidak dapat digunakan" <?php if($row['kondisi_saat_ini'] == 'PC tidak dapat digunakan') echo 'selected'; ?>>PC tidak dapat digunakan</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="keterangan"><b>Keterangan Komputer</b></label>
                                <select class="form-control" id="keterangan" name="keterangan" required>
                                  <option value="Sudah dicek" <?php if($row['keterangan'] == 'Sudah dicek') echo 'selected'; ?>>Sudah dicek</option>
                                  <option value="Belum dicek" <?php if($row['keterangan'] == 'Belum dicek') echo 'selected'; ?>>Belum dicek</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="perangkat_tidak_rusak"><b>Perangkat Tidak Rusak</b></label>
                                <input type="text" class="form-control" id="perangkat_tidak_rusak" name="perangkat_tidak_rusak" value="<?php echo htmlspecialchars($row['perangkat_tidak_rusak']); ?>" required>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="pic_pengecekan"><b>PIC Pengecekan</b></label>
                                <input type="text" class="form-control" id="pic_pengecekan" name="pic_pengecekan" value="<?php echo htmlspecialchars($row['pic_pengecekan']); ?>" required>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success" name="edit">Simpan</button>
                          </div>
                        </form>
                      </div>
                      <?php
                      if (isset($_POST['edit'])) {
                        $id = $_POST['id'];
                        $kode_komputer = mysqli_real_escape_string($conn, htmlspecialchars($_POST['kode_komputer']));
                        $tahun_komputer = mysqli_real_escape_string($conn, htmlspecialchars($_POST['tahun_komputer']));
                        $tanggal_kerusakan = mysqli_real_escape_string($conn, $_POST['tanggal_kerusakan']);
                        $tanggal_pengecekan = mysqli_real_escape_string($conn, $_POST['tanggal_pengecekan']);
                        $kerusakan = date("Y-m-d", strtotime($tanggal_kerusakan));
                        $pengecekan = date("Y-m-d", strtotime($tanggal_pengecekan));
                        $perangkat_yang_rusak = mysqli_real_escape_string($conn, htmlspecialchars($_POST['perangkat_yang_rusak']));
                        $rekomendasi_perbaikan = mysqli_real_escape_string($conn, htmlspecialchars($_POST['rekomendasi_perbaikan']));
                        $kondisi_saat_ini = mysqli_real_escape_string($conn, htmlspecialchars($_POST['kondisi']));
                        $keterangan = mysqli_real_escape_string($conn, htmlspecialchars($_POST['keterangan']));
                        $perangkat_tidak_rusak = mysqli_real_escape_string($conn, htmlspecialchars($_POST['perangkat_tidak_rusak']));
                        $pic_pengecekan = mysqli_real_escape_string($conn, htmlspecialchars($_POST['pic_pengecekan']));
                    
                        $edit = mysqli_query($conn, "UPDATE barang_rusak SET
                            kode_komputer ='$kode_komputer',
                            tahun_komputer ='$tahun_komputer',
                            tanggal_kerusakan ='$kerusakan',
                            tanggal_pengecekan ='$pengecekan',
                            perangkat_yang_rusak ='$perangkat_yang_rusak',
                            rekomendasi_perbaikan ='$rekomendasi_perbaikan',
                            kondisi_saat_ini ='$kondisi_saat_ini',
                            keterangan ='$keterangan',
                            perangkat_tidak_rusak ='$perangkat_tidak_rusak',
                            pic_pengecekan ='$pic_pengecekan'
                            WHERE id ='$id'
                        ");
                    
                        if ($edit) {
                            echo "<script>window.location.href='lapor.php';</script>";
                            exit();
                        } else {
                            echo "<div class='col-md-10 col-sm-12 col-xs-12 ml-5'>";
                            echo "<div class='alert alert-danger mt-4 ml-5' role='alert'>";
                            echo "<p><center>Mengedit data gagal</center></p>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                      ?>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="detailData<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="detailDataLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title fs-5" id="exampleModalLabel">
                          <b>Info Detail Barang</b>
                        </h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-6">
                            <b>Kode Komputer</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['kode_komputer']); ?></b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <b>Tahun Komputer</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['tahun_komputer']); ?></b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <b>Tanggal Kerusakan</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['tanggal_kerusakan']); ?></b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <b>Tanggal Pengecekan</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['tanggal_pengecekan']); ?></b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <b>Perangkat yang Rusak</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['perangkat_yang_rusak']); ?></b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <b>Rekomendasi & Perbaikan</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['rekomendasi_perbaikan']); ?></b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <b>Kondisi Saat Ini</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['kondisi_saat_ini']); ?></b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <b>Keterangan</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['keterangan']); ?></b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <b>Perangkat yang Tidak Rusak</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['perangkat_tidak_rusak']); ?></b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <b>PIC Pengecekan</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['pic_pengecekan']); ?></b></div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                  }
                } else {
                  echo "<tr><td colspan='8'><div class='alert alert-danger' role='alert'><p><center>Data masih kosong</center></p></div></td></tr>";
                }
                ?>
              </table>
              <div class="row m-0">
                <div class="col-lg-5"></div>
                <div class="col-lg-5"></div>
              </div>
            </div>
          </div>
          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mt-3">
            <?php if($page > 1): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page-1; ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
            <?php endif; ?>
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
              </li>
            <?php endfor; ?>
            <?php if($page < $total_pages): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page+1; ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            <?php endif; ?>
            </ul>
          </nav>
        </div>
      </div>
      <footer class="sticky-footer bg-white">
        <div class="container my-auto"></div>
      </footer>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <div class="modal fade" id="tambahLaporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            <b>Tambah Laporan</b>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form name='kirim' method="post">
            <div class="row">
              <div class="col-sm-6">
                <p class="mb-1">
                  <b>Kode Komputer</b>
                </p>
                <input class="form-control mb-3" type="text" placeholder="Masukkan kode komputer" name='kode_komputer' required>
              </div>
              <div class="col-sm-6">
                <p class="mb-1">
                  <b>Tahun Komputer</b>
                </p>
                <input class="form-control mb-3" type="text" placeholder="Masukkan tahun komputer" name='tahun_komputer' required>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <p class="mb-1">
                  <b>Tanggal Kerusakan </b>
                </p>
                <input class="form-control mb-3" type="date" placeholder="Masukkan tanggal kerusakan komputer" name='kerusakan_komputer' required>
              </div>
              <div class="col-sm-6">
                <p class="mb-1">
                  <b>Tanggal Pengecekan </b>
                </p>
                <input class="form-control mb-3" type="date" placeholder="Masukkan tanggal pengecekan komputer" name='pengecekan_komputer' required>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <p class="mb-1">
                  <b>Perangkat Yang Rusak </b>
                </p>
                <input class="form-control mb-3" type="text" placeholder="Masukkan perangkat yang rusak" name='perangkat_rusak' required>
              </div>
              <div class="col-sm-6">
                <p class="mb-1">
                  <b>Rekomendasi Perbaikan </b>
                </p>
                <input class="form-control mb-3" type="text" placeholder="Masukkan rekomendasi & perbaikan" name='rekomendasi_perbaikan' required>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <p class="mb-1">
                  <b>Kondisi Komputer</b>
                </p>
                <select class="form-control mb-3" name='kondisi_komputer' required>
                  <option selected disabled>Pilih kondisi komputer</option>
                  <option value="PC dapat digunakan">PC dapat digunakan</option>
                  <option value="PC tidak dapat digunakan">PC tidak dapat digunakan</option>
                </select>
              </div>
              <div class="col-sm-6">
                <p class="mb-1">
                  <b>Keterangan Komputer</b>
                </p>
                <select class="form-control mb-3" name='keterangan_komputer' required>
                  <option selected disabled>Pilih keterangan komputer</option>
                  <option value="Sudah dicek">Sudah dicek</option>
                  <option value="Belum dicek">Belum dicek</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <p class="mb-1">
                  <b>Perangkat Tidak Rusak</b>
                </p>
                <input class="form-control mb-3" type="text" placeholder="Masukkan perangkat tidak rusak" name='perangkat_tidak_rusak' required>
              </div>
              <div class="col-sm-6">
                <p class="mb-1">
                  <b>PIC Pengecekan</b>
                </p>
                <input class="form-control mb-3" type="text" placeholder="Masukkan PIC pengecekan" name='pic_pengecekan' required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-success" name="kirim">Tambah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="hapusSemuaL" tabindex="-1" aria-labelledby="hapusSemuaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-5" id="exampleModalLabel"><b>Peringatan</b></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          Yakin ingin menghapus <b>SEMUA</b> data?
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <a href="hapus_all_laporan.php" class="btn btn-danger">Hapus</a>
        </div>
      </div>
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
  <script>
  function validateForm() {
    var x = document.getElementById("cari").value;
    if (x.trim() == "") {
      window.location.href = "lapor.php";
      return false;
    }
    return true;
  }
</script>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
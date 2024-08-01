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
  <title>Data Barang - Inventaris Lab RPL</title>
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
      <li class="nav-item active">
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
          $nama = htmlspecialchars($_POST['nama_b']);
          $jenis = htmlspecialchars($_POST['jenis']);
          $jumlah = htmlspecialchars($_POST['jumlah']);
          $kondisi = htmlspecialchars($_POST['kondisi']);
          $deskripsi = htmlspecialchars($_POST['deskripsi']);
          $gambar = $_FILES['pict']['name'];
          $ukuran_file = $_FILES['pict']['size'];
          $gambar_tmp = $_FILES['pict']['tmp_name'];
          $path = "images/".$gambar;
          $wet = mysqli_query($conn, "SELECT * FROM masuk WHERE nama='$nama' AND jenis='$jenis' AND jumlah='$jumlah' AND kondisi='$kondisi' AND deskripsi = '$deskripsi'");
          $chak = mysqli_num_rows($wet);
          if ($chak > 0) {
            echo "<div class='col-md-10 col-sm-12 col-xs-12 ml-5'>";
            echo "<div class='alert alert-warning mt-4 ml-5' role='alert'>";
            echo "<p><center>Data yang Anda kirim sudah tersedia</center></p>";
            echo "</div>";
            echo "</div>";
          }else{
            $gambar_data = mysqli_real_escape_string($conn, file_get_contents($gambar_tmp));
            $insert = mysqli_query($conn, "INSERT INTO masuk (nama, jenis, jumlah, kondisi, gambar, path_gambar, deskripsi) VALUES ('$nama', '$jenis', '$jumlah', '$kondisi', '$gambar_data', '$path', '$deskripsi')");
            if($insert){
              move_uploaded_file($gambar_tmp, $path);
              
            }else{
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
            <h2><b><center>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Data Barang Lab RPL</center></b></h2>
          </div>
        </div>
        <div class="card shadow  ml-4 mr-4">
          <div class="card-header py-3">
            <div class="row">
              <div class="col-md-7">
                <h6 class="mt-1 font-weight-bold text-primary">Data Barang</h6>
              </div>
              <div class="col justify-content-end"></div>
              <div class="mr-2">
                <?php
                $cep = mysqli_query($conn, "SELECT * FROM masuk");
                $tesd= mysqli_num_rows($cep);
                if($tesd > 0 ){
                  echo "<form name='hapus' method='post'>";
                  echo "<button type='button' class='d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm' data-toggle='modal' data-target='#hapusSemua'><i class='fas fa-solid fa-trash fa-sm text-white mr-2'></i>Hapus Semua<i class='fas fa-solid fa-trash fa-sm text-white ml-2'></i></button>";
                  echo "</form>";
                }else{
                }
                ?>
              </div>
              <div class="mr-2">
              <?php
                $cep = mysqli_query($conn, "SELECT * FROM masuk");
                $tesd= mysqli_num_rows($cep);
                if($tesd > 0 ){
                  echo "<a href='export_excel_data.php' class='d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm'>";
                  echo "<i class='fas fa-download fa-sm text-white mr-1'></i>";
                  echo "Cetak Excel";
                  echo "</a>";
                }else{
                }
              ?>
              </div>
              <div class="mr-1">
                <button type="button" data-toggle="modal" data-target="#tambahData" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                  <i class="fas fa-plus fa-sm text-white mr-1"></i>
                  Tambah Data
                </button>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <p class="ml-4 mt-4">
                <?php
                $jumlahh = mysqli_query($conn, "SELECT SUM(jumlah) as jumlah FROM masuk");
                $barangg = mysqli_query($conn, "SELECT COUNT(DISTINCT jenis) as barang FROM masuk");
                $totalJ =mysqli_fetch_array($jumlahh);
                $totalB = mysqli_fetch_array($barangg);
                echo "Total Stok: &nbsp<b>". $totalJ['jumlah']."pcs</b>";
                echo "&nbsp; &nbsp; &nbsp; Total Jenis Barang: &nbsp<b>". number_format($totalB['barang'])." jenis</b>"; 
                ?>
              </p>
            </div>
            <div class="col-md-4 mt-4 mb-4">
              <form class="form-inline my-2 my-lg-0" action="cari.php" method="get" name="cari" onsubmit="return validateForm()">
                <input class="form-control mr-sm-2" type="search" placeholder="Cari" aria-label="Cari" name='cari' value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
              </form>
            </div>
            
          </div>
          <?php
          $per_page = 10;
          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
          $start = ($page - 1) * $per_page;
          $total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM masuk");
          $total_data = mysqli_fetch_assoc($total_query)['total'];
          $total_pages = ceil($total_data / $per_page);
          ?>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive service">
              <table class="table table-bordered table-hover  mt-0 text-nowrap css-serial">
                <thead>
                  <tr>
                    <th scope="col" width="3%">No</th>
                    <th scope="col" width="10%">Gambar Barang</th>
                    <th scope="col" width="15%">Nama Barang</th>
                    <th scope="col" width="15%">Jenis Barang</th>
                    <th scope="col" width="5%">Stok</th>
                    <th scope="col" width="12%">Kondisi Barang</th>
                    <th scope="col">Deskripsi Barang</th>
                    <th scope="col" width="6%">Opsi</th>
                  </tr>
                </thead>
                <?php
                if(isset($_GET['cari']) && !empty($_GET['cari'])){
                  $cari = mysqli_real_escape_string($conn, $_GET['cari']);
                  $_SESSION['cari'] = $cari;
                  $brg = mysqli_query($conn, "SELECT * FROM masuk WHERE id LIKE '%".$cari."%' OR nama LIKE '%".$cari."%' OR jenis LIKE '%".$cari."%' ");
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
                  $query = "SELECT * FROM masuk LIMIT $start, $per_page";
                  $brg = mysqli_query($conn, $query);
                }
                if(mysqli_num_rows($brg) > 0){
                  $no = $start + 1;
                  while($row = mysqli_fetch_assoc($brg)){
                ?>
                <tbody>
                  <tr class="text-wrap">
                    <th scope="row"><?php echo $row['id'] ?></th>
                    <?php
                    echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['gambar']) . "' alt='Gambar' style='width: 150px; height: 150px; object-fit: cover'></td>";
                    ?>
                    <td><?php echo $row['nama'] ?></td>
                    <td><?php echo $row['jenis'] ?></td>
                    <td><?php echo $row['jumlah'] ?></td>
                    <td><?php echo $row['kondisi'] ?></td>
                    <td><?php echo $row['deskripsi'] ?></td>
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
                        <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Hapus</a>
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
                          <div class="form-group">
                            <label for="nama_b"><b>Nama Barang</b></label>
                            <input type="text" class="form-control" id="nama_b" name="nama_b" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
                          </div>
                          <div class="form-group">
                            <label for="jenis"><b>Jenis Barang</b></label>
                            <select class="form-control" id="jenis" name="jenis" required>
                              <option value="Monitor" <?php if($row['jenis'] == 'Monitor') echo 'selected'; ?>>Monitor</option>
                              <option value="Keyboard" <?php if($row['jenis'] == 'Keyboard') echo 'selected'; ?>>Keyboard</option>
                              <option value="Mouse" <?php if($row['jenis'] == 'Mouse') echo 'selected'; ?>>Mouse</option>
                              <option value="Case" <?php if($row['jenis'] == 'Case') echo 'selected'; ?>>Case</option>
                              <option value="Komponen CPU" <?php if($row['jenis'] == 'Komponen CPU') echo 'selected'; ?>>Komponen CPU</option>
                              <option value="Meja" <?php if($row['jenis'] == 'Meja') echo 'selected'; ?>>Meja</option>
                              <option value="Kursi" <?php if($row['jenis'] == 'Kursi') echo 'selected'; ?>>Kursi</option>
                              <option value="Kabel LAN Ethernet" <?php if($row['jenis'] == 'Kabel LAN Ethernet') echo 'selected'; ?>>Kabel LAN Ethernet</option>
                              <option value="AC" <?php if($row['jenis'] == 'AC') echo 'selected'; ?>>AC</option>
                              <option value="Printer" <?php if($row['jenis'] == 'Printer') echo 'selected'; ?>>Printer</option>
                              <option value="Stopkontak" <?php if($row['jenis'] == 'Stopkontak') echo 'selected'; ?>>Stopkontak</option>
                              <option value="CCTV" <?php if($row['jenis'] == 'CCTV') echo 'selected'; ?>>CCTV</option>
                              <option value="Lampu" <?php if($row['jenis'] == 'Lampu') echo 'selected'; ?>>Lampu</option>
                              <option value="Proyektor" <?php if($row['jenis'] == 'Proyektor') echo 'selected'; ?>>Proyektor</option>
                              <option value="Papan Tulis" <?php if($row['jenis'] == 'Papan Tulis') echo 'selected'; ?>>Papan Tulis</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="jumlah"><b>Jumlah Barang</b></label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($row['jumlah']); ?>" required>
                          </div>
                          <div class="form-group">
                            <label for="kondisi"><b>Kondisi Barang</b></label>
                            <select class="form-control" id="kondisi" name="kondisi" required>
                              <option value="Berfungsi" <?php if($row['kondisi'] == 'Berfungsi') echo 'selected'; ?>>Berfungsi</option>
                              <option value="Rusak" <?php if($row['kondisi'] == 'Rusak') echo 'selected'; ?>>Rusak</option>
                            </select>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success" name="edit">Simpan</button>
                          </div>
                        </form>
                      </div>
                      <?php
                      if(isset($_POST['edit'])){
                        $id = $_POST['id'];
                        $nama = mysqli_real_escape_string($conn, htmlspecialchars($_POST['nama_b']));
                        $jenis = mysqli_real_escape_string($conn, htmlspecialchars($_POST['jenis']));
                        $jumlah = mysqli_real_escape_string($conn, htmlspecialchars($_POST['jumlah']));
                        $kondisi = mysqli_real_escape_string($conn, htmlspecialchars($_POST['kondisi']));
                        $edit = mysqli_query($conn, "UPDATE masuk SET
                          nama ='$nama',
                          jenis ='$jenis',
                          kondisi ='$kondisi',
                          jumlah ='$jumlah'
                          WHERE id ='$id'
                        ");
                        if($edit){
                          echo "<script>window.location.href='data.php';</script>";
                          exit();
                        }else{
                          
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
                          <div class="col-md-4">
                            <b>Nama Barang</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['nama']); ?></b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <b>Jenis Barang</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['jenis']); ?></b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <b>Jumlah Barang</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['jumlah']); ?></b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <b>Kondisi Barang</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['kondisi']); ?></b></div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <b>Deskripsi Barang</b>
                          </div>
                          <div>:</div>
                          <div class="col"><b><?php echo htmlspecialchars($row['deskripsi']); ?></b></div>
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
  <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            <b>Tambah Data</b>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form name='kirim' method='post' enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-sm-12 col-xs-12">
                  <p class="mb-1">
                    <b>Nama Barang</b>
                  </p>
                  <input class="form-control mb-3" type="text" placeholder="Masukkan nama barang" name='nama_b' required>
                </div>
                <div class="col-sm-12 col-xs-12">
                <p class="mb-1">
                  <b>Jenis Barang</b>
                </p>
                <select class="form-control mb-3" name='jenis' value=""required>
                  <option selected disabled>Pilih jenis barang</option>
                  <option value="Monitor">Monitor</option>
                  <option value="Keyboard">Keyboard</option>
                  <option value="Mouse">Mouse</option>
                  <option value="Case">Case</option>
                  <option value="Komponen CPU">Komponen CPU</option>
                  <option value="Meja">Meja</option>
                  <option value="Kursi">Kursi</option>
                  <option value="Kabel LAN Ethernet">Kabel LAN Ethernet</option>
                  <option value="Printer">Printer</option>
                  <option value="Lampu">Lampu</option>
                  <option value="Proyektor">Proyektor</option>
                  <option value="Papan Tulis">Papan Tulis</option>
                  <option value="Stopkontak">Stopkontak</option>
                  <option value="CCTV">CCTV</option>
                  <option value="AC">AC</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-1"></div>
              <div class="col-sm-12 col-xs-12">
                <p class="mb-1">
                  <b>Jumlah Barang</b>
                </p>
                <input class="form-control mb-3" type="number" placeholder="Masukkan jumlah barang" name='jumlah' required>
              </div>
              <div class="col-sm-12 col-xs-12">
                <p class="mb-1">
                  <b>Kondisi Barang</b>
                </p>
                <select class="form-control mb-3" name='kondisi' required>
                  <option selected disabled>Pilih kondisi barang</option>
                  <option value="Berfungsi">Berfungsi</option>
                  <option value="Rusak">Rusak</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-1"></div>
              <div class="col-sm-12 col-xs-12">
                <p class="mb-1">
                  <b>Deskripsi Barang</b>
                </p>
                <input class="form-control mb-3" type="text" placeholder="Masukkan deskripsi barang" name='deskripsi' required>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-xs-12">
                <p class="mb-1">
                  <b>Gambar Barang</b>
                </p>
                <input class="form-control mb-3" type="file" name="pict"  required>
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
  <div class="modal fade" id="hapusSemua" tabindex="-1" aria-labelledby="hapusSemuaLabel" aria-hidden="true">
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
          <a href="hapus_all_data.php" class="btn btn-danger">Hapus</a>
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
      window.location.href = "data.php";
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
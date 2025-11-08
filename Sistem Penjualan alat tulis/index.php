<?php

require 'ceklogin.php';

//Menghitung jumlah pesanan
$h1 = mysqli_query($koneksi, "select * from pesanan");
$h2 = mysqli_num_rows($h1);

$ambiluser = mysqli_query($koneksi,"select * from user");
$nu = mysqli_fetch_array($ambiluser);
$username = $nu['username'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistem Penjualan Alat Tulis</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet"/>
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Aplikasi Penjualan</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fa-regular fa-clipboard"></i></div>
                                Order
                            </a>
                            <a class="nav-link" href="stok.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-cubes-stacked"></i></div>
                                Stok Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-address-card"></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $username; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mb-2">Data Pesanan</h1>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Jumlah Pesanan : <?php echo $h2; ?></div>
                                </div>
                            </div>
                        </div>

                            <button type="button" class="btn btn-info mb-4" data-bs-toggle="modal" data-bs-target="#myModal">
                            Tambah Pesanan Baru
                            </button>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pesanan
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>



                                        <tr>
                                            <th>ID Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $data = mysqli_query($koneksi,"select * from pesanan p, pelanggan pl where p.idpelanggan=pl.idpelanggan");
                                    $i = 1;
                                    while($p=mysqli_fetch_array($data)){
                                        $idorder = $p['idorder'];
                                        $tanggal = $p['tanggal'];
                                        $namapelanggan = $p['namapelanggan'];
                                        $alamat = $p['alamat'];
                                        $hitungjumlah = mysqli_query($koneksi,"select * from detailpesanan where idpesanan='$idorder'");
                                        $jumlah = mysqli_num_rows($hitungjumlah);
                                    ?>
                                        <tr>
                                            <td><?php echo $idorder;?></td>
                                            <td><?php echo $tanggal; ?></td>
                                            <td><?php echo $namapelanggan; ?> - <?php echo $alamat; ?></td>
                                            <td><?php echo $jumlah; ?></td>
                                            <td><a href="view.php?idp=<?php echo $idorder; ?>" class="btn btn-primary">Details</a> 
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $idorder; ?>">
                                            Delete
                                            </button></td>
                                        </tr>


                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="delete<?php echo $idorder; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Data Pesanan</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form method="post">

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                Apakah Anda Yakin Ingin Menghapus Data Pesanan Ini?
                                                <input type="hidden" name="ido" value="<?php echo $idorder ?>">
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="hapusdatapesanan">Ya</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                                            </div>
                                            </form>
                                            </div>
                                        </div>
                                        </div>

                                        <?php
                                        };
                                        ?>



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>



    <!-- untuk menambahkan pesanan baru dibagian tombol pesanan baru -->
    <!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Pesanan Baru</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="post">

      <!-- Modal body -->
      <div class="modal-body">
      <input type="text" name="idorder" class="form-control mb-4" placeholder="ID Pesanan">
      Pilih Pelanggan
        <select name="idpelanggan" class="form-control">

        <?php
        $getpelanggan = mysqli_query($koneksi, "select * from pelanggan");
        while($pl=mysqli_fetch_array($getpelanggan)){
            $namapelanggan = $pl['namapelanggan'];
            $idpelanggan = $pl['idpelanggan'];
            $alamat = $pl['alamat'];
            ?>
            <option value="<?php echo $idpelanggan ?>"><?php echo $namapelanggan; ?> - <?php echo $alamat; ?></option>
            <?php
        }
        ?>
    </select>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" name="tambahpesanan">Submit</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </form>
    </div>
  </div>
</div>


</html>

<?php

require 'ceklogin.php';

$h1 = mysqli_query($koneksi, "select * from produk");
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
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Aplikasi Penjualan</a>
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
                        <h1 class="mt-4">Data Stok Barang</h1>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Jumlah Barang : <?php echo $h2; ?></div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-info mb-4" data-bs-toggle="modal" data-bs-target="#myModal">
                            Tambah Barang Baru
                            </button>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Barang
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>




                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Deskripsi</th>
                                            <th>Stok</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $data = mysqli_query($koneksi,"select * from produk");
                                    $i = 1;
                                    while($p=mysqli_fetch_array($data)){
                                        $namaproduk = $p['namaproduk'];
                                        $deskripsi = $p['deskripsi'];
                                        $harga = $p['harga'];
                                        $stok = $p['stok'];
                                        $idproduk = $p['idproduk'];
                                    ?>
                                        <tr>
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $namaproduk ?></td>
                                            <td><?php echo $deskripsi ?></td>
                                            <td><?php echo $stok ?></td>
                                            <td>Rp.<?php echo number_format($harga) ?></td>
                                            <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?php echo $idproduk; ?>">
                                            Edit
                                            </button> 
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $idproduk; ?>">
                                            Delete
                                            </button></td>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="edit<?php echo $idproduk; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Barang</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form method="post">

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <input type="text" name="idproduk" class="form-control mt-2" placeholder="ID Produk" value="<?php echo $idproduk ?>" disabled>
                                                <input type="text" name="namaproduk" class="form-control mt-2" placeholder="Nama Produk" value="<?php echo $namaproduk ?>">
                                                <input type="text" name="deskripsi" class="form-control mt-2" placeholder="Deskripsi" value="<?php echo $deskripsi ?>">
                                                <input type="num" name="harga" class="form-control mt-2 mb-2" placeholder="Harga Produk" value="<?php echo $harga?>">
                                                <input type="hidden" name="idp" value="<?php echo $idproduk ?>">
                                                Apakah Anda Yakin?
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="editbarang">Ya</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                                            </div>
                                            </form>
                                            </div>
                                        </div>
                                        </div>



                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="delete<?php echo $idproduk; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus <?php echo $namaproduk ?></h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form method="post">

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                Apakah Anda Yakin Ingin Menghapus Barang Ini?
                                                <input type="hidden" name="idp" value="<?php echo $idproduk ?>">
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="hapusbarang">Ya</button>
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



    <!-- Untuk Menambahkan Stok Barang Baru pada tombol Tambah Barang Baru -->
    <!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Barang Baru</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="post">

      <!-- Modal body -->
      <div class="modal-body">
        <input type="text" name="idproduk" class="form-control mt-2" placeholder="ID Produk">
        <input type="text" name="namaproduk" class="form-control mt-2" placeholder="Nama Produk">
        <input type="text" name="deskripsi" class="form-control mt-2" placeholder="Deskripsi">
        <input type="num" name="stok" class="form-control mt-2" placeholder="Stok Awal">
        <input type="num" name="harga" class="form-control mt-2" placeholder="Harga Produk">
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" name="tambahbarang">Submit</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </form>
    </div>
  </div>
</div>



</html>

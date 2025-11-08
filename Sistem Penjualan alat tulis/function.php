<?php

session_start();

//koneksi
$koneksi = mysqli_connect("localhost","root","","sistem_penjualan_alat_tulis");

if(mysqli_connect_error()) {
        
    echo "Koneksi Gagal : ".mysqli_connect_error();
    }

//login
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($koneksi, "select * from user where username = '$username' and password = '$password'");
    $hitung = mysqli_num_rows($check);

    if($hitung>0){
        $_SESSION['login'] = 'True';
        header('location:index.php');
    }else{
        echo'
        <script>alert("Username atau Password Salah");
        window.location.href="login.php"
        </script>
        ';
    }
}

//new username
if(isset($_POST['create'])){
    $newusername = $_POST['newusername'];
    $newpassword = $_POST['newpassword'];

    $tambahusername = mysqli_query($koneksi, "insert into user (username,password) values ('$newusername','$newpassword')");

    if($tambahusername){
        header('location:login.php');
    }else{
        echo'
        <script>alert("Username atau Password Salah");
        window.location.href="login.php"
        </script>
        ';
    }
}

//ganti password
if(isset($_POST['changepassword'])){
    $username = $_POST['username'];
    $newpassword = $_POST['newpassword'];

    $gantipassword = mysqli_query($koneksi, "update user set password='$newpassword' where username='$username'");

    if($gantipassword){
        header('location:login.php');
    }else{
        echo'
        <script>alert("Username Salah");
        window.location.href="login.php"
        </script>
        ';
    }
}

//Tambah Barang di Stok Barang
if(isset($_POST['tambahbarang'])){
    $idproduk = $_POST['idproduk'];
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $tambahbarang = mysqli_query($koneksi,"insert into produk (idproduk,namaproduk,deskripsi,harga,stok) values ('$idproduk','$namaproduk','$deskripsi','$harga','$stok')");

    if($tambahbarang){
        header('location:stok.php');
    }else{
        echo'
        <script>alert("Gagal Menambah barang baru");
        window.location.href="stok.php"
        </script>
        ';
    }

}

//Tambah Pelanggan Di Kelola Pelanggan
if(isset($_POST['tambahpelanggan'])){
    $idpelanggan = $_POST['idpelanggan'];
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];

    $tambahpelanggan = mysqli_query($koneksi,"insert into pelanggan (idpelanggan,namapelanggan,no_telp,alamat) values ('$idpelanggan','$namapelanggan','$notelp','$alamat')");

    if($tambahpelanggan){
        header('location:pelanggan.php');
    }else{
        echo'
        <script>alert("Gagal Menambah Pelanggan Baru");
        window.location.href="pelanggan.php"
        </script>
        ';
    }

}

//Tambah Pesanan Di Order
if(isset($_POST['tambahpesanan'])){
    $idorder = $_POST['idorder'];
    $idpelanggan = $_POST['idpelanggan'];

    $tambahpesanan = mysqli_query($koneksi,"insert into pesanan (idorder,idpelanggan) values ('$idorder','$idpelanggan')");

    if($tambahpesanan){
        header('location:index.php');
    }else{
        echo'
        <script>alert("Gagal Menambah Pelanggan Baru");
        window.location.href="index.php"
        </script>
        ';
    }

}

//Tambah Detail Pesanan Di Order bagian Tampilkan
if(isset($_POST['addproduk'])){
    $iddetailpesanan = $_POST['iddetailpesanan'];
    $idproduk = $_POST['idproduk'];
    $idp = $_POST['idp'];
    $qty = $_POST['qty'];

    $hitung1 = mysqli_query($koneksi, "select * from produk where idproduk='$idproduk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stoksekarang = $hitung2['stok'];

    if($stoksekarang>=$qty){

    $selisih = $stoksekarang-$qty;

    $tambahproduk = mysqli_query($koneksi,"insert into detailpesanan (iddetailpesanan,idpesanan,idproduk,qty) values ('$iddetailpesanan','$idp','$idproduk','$qty')");
    $update = mysqli_query($koneksi,"update produk set stok='$selisih' where idproduk='$idproduk'");


    if($tambahproduk&&$update){
        header('location:view.php?idp='.$idp);
    }else{
        echo'
        <script>alert("Gagal Menambah Pesanan Baru");
        window.location.href="view.php?idp='.$idp.'"
        </script>
        ';
    }
}else{
    echo'
        <script>alert("Stok Tidak Cukup");
        window.location.href="view.php?idp='.$idp.'"
        </script>
        ';
}

}

//Tambah Barang Masuk
if(isset($_POST['barangmasuk'])){
    $idmasuk = $_POST['idbarangmasuk'];
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    //cari tahu stok di stok barang
    $caristok = mysqli_query($koneksi,"select * from produk where idproduk='$idproduk'");
    $caristok1 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok1['stok'];

    //hitung
    $newstok = $stoksekarang+$qty;

    $tambahmasuk = mysqli_query($koneksi,"insert into masuk (idmasuk,idproduk,qty) values ('$idmasuk','$idproduk','$qty')");
    $update = mysqli_query($koneksi,"update produk set stok='$newstok' where idproduk='$idproduk'");

    if($tambahmasuk&&$update){
        header('location:masuk.php');
    }else{
        echo'
        <script>alert("Gagal menambahkan barang");
        window.location.href="masuk.php"
        </script>
        ';
    }

}

//Hapus Produk Pesanan Di Detail Pesanan
if(isset($_POST['hapusprodukpesanan'])){
    $idp = $_POST['idp'];
    $idpr = $_POST['idpr'];
    $idorder = $_POST['idorder'];

    $cek1 = mysqli_query($koneksi,"select * from detailpesanan where iddetailpesanan='$idp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    $cek3 = mysqli_query($koneksi,"select * from produk where idproduk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stoksekarang = $cek4['stok'];

    $hitung = $stoksekarang+$qtysekarang;

    $update = mysqli_query($koneksi,"update produk set stok='$hitung' where idproduk='$idpr'");
    $hapus = mysqli_query($koneksi,"delete from detailpesanan where idproduk='$idpr' and iddetailpesanan='$idp'");

    if($update&&$hapus){
        header('location:view.php?idp='.$idorder);
    }else{
        echo'
        <script>alert("Gagal Menghapus Barang");
        window.location.href="view.php?idp='.$idorder.'"
        </script>
        ';
    }
}

//edit Stok Barang
if(isset($_POST['editbarang'])){
    $namaproduk = $_POST['namaproduk'];
    $desc = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idp = $_POST['idp'];

    $editbarang = mysqli_query($koneksi,"update produk set namaproduk='$namaproduk', deskripsi='$desc', harga='$harga' where idproduk='$idp'");

    if($editbarang){
        header('location:stok.php');
    }else{
        echo'
        <script>alert("Gagal Edit");
        window.location.href="stok.php"
        </script>
        ';
    }

}

//hapus Stok Barang
if(isset($_POST['hapusbarang'])){
    $idp = $_POST['idp'];

    $hapusbarang = mysqli_query($koneksi,"delete from produk where idproduk='$idp'");

    if($hapusbarang){
        header('location:stok.php');
    }else{
        echo'
        <script>alert("Gagal Hapus");
        window.location.href="stok.php"
        </script>
        ';
    }

}

//Edit Pelanggan
if(isset($_POST['editpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $idpelanggan = $_POST['idpl'];

    $editpelanggan = mysqli_query($koneksi,"update pelanggan set namapelanggan='$namapelanggan', no_telp='$notelp', alamat='$alamat' where idpelanggan='$idpelanggan'");

    if($editpelanggan){
        header('location:pelanggan.php');
    }else{
        echo'
        <script>alert("Gagal Edit");
        window.location.href="pelanggan.php"
        </script>
        ';
    }

}

//hapus Pelanggan
if(isset($_POST['hapuspelanggan'])){
    $idpl = $_POST['idpl'];

    $hapuspelanggan = mysqli_query($koneksi,"delete from pelanggan where idpelanggan='$idpl'");

    if($hapuspelanggan){
        header('location:pelanggan.php');
    }else{
        echo'
        <script>alert("Gagal Hapus");
        window.location.href="pelanggan.php"
        </script>
        ';
    }

}

//Edit Barang Masuk
if(isset($_POST['editbarangmasuk'])){
    $qty = $_POST['qty'];
    $idmasuk = $_POST['idm'];
    $idproduk = $_POST['idp'];

    //cari tahu qty di barang masuk
    $caritahu = mysqli_query($koneksi,"select * from masuk where idmasuk='$idmasuk'");
    $caritahu1 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu1['qty'];

    //cari tahu stok di stok barang
    $caristok = mysqli_query($koneksi,"select * from produk where idproduk='$idproduk'");
    $caristok1 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok1['stok'];

    if($qty >= $qtysekarang){
        $selisih = $qty-$qtysekarang;
        $newstok = $stoksekarang+$selisih;

        $editpelanggan = mysqli_query($koneksi,"update masuk set qty='$qty' where idmasuk='$idmasuk'");
        $query = mysqli_query($koneksi,"update produk set stok='$newstok' where idproduk='$idproduk'");

    if($editpelanggan&&$query){
        header('location:masuk.php');
    }else{
        echo'
        <script>alert("Gagal Edit");
        window.location.href="masuk.php"
        </script>
        ';
    }
    }else{
        $selisih = $qtysekarang-$qty;
        $newstok = $stoksekarang-$selisih;

        $editpelanggan = mysqli_query($koneksi,"update masuk set qty='$qty' where idmasuk='$idmasuk'");
        $query = mysqli_query($koneksi,"update produk set stok='$newstok' where idproduk='$idproduk'");
    if($editpelanggan&&$query){
        header('location:masuk.php');
    }else{
        echo'
        <script>alert("Gagal Edit");
        window.location.href="masuk.php"
        </script>
        ';
    }
    }

}

//hapus Data Barang Masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];

    //cari tahu qty di barang masuk
    $caritahu = mysqli_query($koneksi,"select * from masuk where idmasuk='$idmasuk'");
    $caritahu1 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu1['qty'];

    //cari tahu stok di stok barang
    $caristok = mysqli_query($koneksi,"select * from produk where idproduk='$idproduk'");
    $caristok1 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok1['stok'];

    //hitung selisih
    $newstok = $stoksekarang-$qtysekarang;

    $editpelanggan = mysqli_query($koneksi,"delete from masuk where idmasuk='$idm'");
    $query = mysqli_query($koneksi,"update produk set stok='$newstok' where idproduk='$idp'");

    if($editpelanggan&&$query){
        header('location:masuk.php');
    }else{
        echo'
        <script>alert("Gagal Edit");
        window.location.href="masuk.php"
        </script>
        ';
    }

}

//hapus order
if(isset($_POST['hapusdatapesanan'])){
    $ido = $_POST['ido'];

    $cekdata = mysqli_query($koneksi,"select * from detailpesanan dp where idpesanan='$ido'");
    
    while($data = mysqli_fetch_array($cekdata)){
        $qty = $data['qty'];
        $idproduk = $data['idproduk'];
        $iddp = $data['iddetailpesanan'];

        //cari tahu stok di stok barang
        $caristok = mysqli_query($koneksi,"select * from produk where idproduk='$idproduk'");
        $caristok1 = mysqli_fetch_array($caristok);
        $stoksekarang = $caristok1['stok'];

        $newstok = $stoksekarang+$qty;
        $queryupdate = mysqli_query($koneksi,"update produk set stok='$newstok' where idproduk='$idproduk'");

        //hapus data
        $querydelete = mysqli_query($koneksi,"delete from detailpesanan where iddetailpesanan='$iddp'");
    }

    $hapuspesanan = mysqli_query($koneksi,"delete from pesanan where idorder='$ido'");

    if($queryupdate&&$querydelete&&$hapuspesanan){
        header('location:index.php');
    }else{
        echo'
        <script>alert("Gagal Hapus");
        window.location.href="index.php"
        </script>
        ';
    }

}

//Edit Detail Pesanan
if(isset($_POST['editdetailpesanan'])){
    $qty = $_POST['qty'];
    $iddp = $_POST['iddp'];
    $idpr = $_POST['idpr'];
    $idp = $_POST['idp'];

    //cari tahu qty di barang masuk
    $caritahu = mysqli_query($koneksi,"select * from detailpesanan where iddetailpesanan='$iddp'");
    $caritahu1 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu1['qty'];

    //cari tahu stok di stok barang
    $caristok = mysqli_query($koneksi,"select * from produk where idproduk='$idpr'");
    $caristok1 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok1['stok'];

    if($qty >= $qtysekarang){
        $selisih = $qty-$qtysekarang;
        $newstok = $stoksekarang-$selisih;

        $editdetailpesanan = mysqli_query($koneksi,"update detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");
        $query = mysqli_query($koneksi,"update produk set stok='$newstok' where idproduk='$idpr'");

    if($editdetailpesanan&&$query){
        header('location:view.php?idp='.$idp);
    }else{
        echo'
        <script>alert("Gagal Edit");
        window.location.href="view.php?.idp='.$idp.'"
        </script>
        ';
    }
    }else{
        $selisih = $qtysekarang-$qty;
        $newstok = $stoksekarang+$selisih;

        $editdetailpesanan = mysqli_query($koneksi,"update detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");
        $query = mysqli_query($koneksi,"update produk set stok='$newstok' where idproduk='$idpr'");
    if($editdetailpesanan&&$query){
        header('location:view.php?idp='.$idp);
    }else{
        echo'
        <script>alert("Gagal Edit");
        window.location.href="view.php?.idp='.$idp.'"
        </script>
        ';
    }
    }

}

?>
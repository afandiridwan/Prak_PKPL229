<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}
?>

<?php
include 'functions.php';
// Your PHP code here.

// Home Page template below.
?>



<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>User Dashboard</title>
</head>

<?= template_header('Home') ?>

<!-- <div class="content">
    <h2>Home</h2>
    <p>Welcome to Data Penduduk!</p>
</div> -->
<?php
//Koneksi Database
$server = "localhost";
$user = "root";
$password = "";
$database = "login_register";

//buat koneksi
$koneksi = mysqli_connect($server, $user, $password, $database) or die(mysqli_error($koneksi));


//jika tombol simpan diklik
if (isset($_POST['bsimpan'])) {


    if (isset($_GET['hal']) == "edit") {
        $edit = mysqli_query($koneksi, "UPDATE tbarang SET
                                                nama = '$_POST[tnama]',
                                                asal = '$_POST[tasal]',
                                                jumlah = '$_POST[tjumlah]',
                                                satuan = '$_POST[tsatuan]',
                                                tanggal_diterima = '$_POST[ttanggal_diterima]'
                                            WHERE id_barang = '$_GET[id]'
                                                ");

        if ($edit) {
            echo "<script>
            alert('Edit data Sukses!');
            document.location='index.php';
            </script>";
        } else {
            echo "<script>
        alert('Edit data Gagal!');
        document.location='index.php';
        </script>";
        }
    } else {

        //Data akan disimpan baru
        $simpan = mysqli_query($koneksi, " INSERT INTO tbarang (kode, nama, asal, jumlah, satuan, tanggal_diterima)
                                            VALUE ( '$_POST[tkode]',
                                                    '$_POST[tnama]',
                                                    '$_POST[tasal]',
                                                    '$_POST[tjumlah]',
                                                    '$_POST[tsatuan]',
                                                    '$_POST[ttanggal_diterima]')
                                                ");
        //uji jika simpan data sukses
        if ($simpan) {
            echo "<script>
            alert('Simpan data Sukses!');
            document.location='index.php';
            </script>";
        } else {
            echo "<script>
            alert('Simpan data Gagal!');
            document.location='index.php';
            </script>";
        }

    }

}

//deklasrasi variabel untuk menampung data yang akan di edit
$vkode = "";
$vnama = "";
$vasal = "";
$vjumlah = "";
$vsatuan = "";
$vtanggal_diterima = "";



//pengujian jika tombol hedit / hapus diklik
if (isset($_GET['hal'])) {

    //pengujian jika edit data
    if ($_GET['hal'] == "edit") {

        //tampilkam data yang akan diedit
        $tampil = mysqli_query($koneksi, "SELECT * FROM tbarang WHERE id_barang = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            //jika data ditemukan, maka data di tampung ke dalam variabel
            $vkode = $data['kode'];
            $vnama = $data['nama'];
            $vasal = $data['asal'];
            $vjumlah = $data['jumlah'];
            $vsatuan = $data['satuan'];
            $vtanggal_diterima = $data['tanggal_diterima'];
        }

    } else if ($_GET['hal'] == "hapus") {
        //persiapan hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM tbarang WHERE id_barang = '$_GET[id]' ");
        //uji jika hapus data sukses
        if ($hapus) {
            echo "<script>
            alert('Hapus data Sukses!');
            document.location='index.php';
            </script>";
        } else {
            echo "<script>
            alert('Hapus data Gagal!');
            document.location='index.php';
            </script>";
        }
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Data Inventaris</title>
</head>

<body>
    <div class="container">
        <div class="content read">
            <h2 class="text-center">DATA INVENTARIS</h2>
        </div>
        <h3> </h3>
        <!-- <h3 class="text-center">Data Iventaris</h3> -->


        <!-- input barang -->
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-info text-light">
                        Form input data barang
                    </div>
                    <div class="card-body">

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Kode Barang</label>
                                <input type="text" name="tkode" value="<?= $vkode ?>" class="form-control"
                                    id="exampleFormControlInput1" placeholder="Masukan Kode Barang">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" name="tnama" value="<?= $vnama ?>" class="form-control"
                                    id="exampleFormControlInput1" placeholder="Masukan Nama Barang">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Asal Barang</label>
                                <select class="form-select" name="tasal">
                                    <option value="<?= $vasal ?>" selected>
                                        <?= $vasal ?>
                                    </option>
                                    <option value="Pembelian">Pembelian</option>
                                    <option value="Hibah">Hibah</option>
                                    <option value="Bantuan">Bantuan</option>
                                    <option value="Sumbangan">Sumbangan</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Jumlah</label>
                                        <input type="number" name="tjumlah" value="<?= $vjumlah ?>" class="form-control"
                                            id="exampleFormControlInput1" placeholder="Masukan Jumlah Barang">
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Satuan</label>
                                        <select class="form-select" name="tsatuan">
                                            <option value="<?= $vsatuan ?>" selected>
                                                <?= $vsatuan ?>
                                            </option>
                                            <option value="Unit">Unit</option>
                                            <option value="Kotak">Kotak</option>
                                            <option value="Pcs">Pcs</option>
                                            <option value="Pack">Pack</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Diterima</label>
                                        <input type="date" name="ttanggal_diterima" value="<?= $vtanggal_diterima ?>"
                                            class="form-control" id="exampleFormControlInput1"
                                            placeholder="Masukan Jumlah Barang">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <hr>
                                    <button class="btn btn-primary" name="bsimpan" type="submit">Simpan</button>
                                    <button class="btn btn-danger" name="bkosongkan" type="reset">Kosongkan</button>
                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="card-footer bg-info">

                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-info text-light">
                Data Barang
            </div>
            <div class="card-body">
                <div class="col-md-6 mx-auto">
                    <form method="POST">
                        <div class="input-group mb-3">
                            <input type="text" name="tcari" class="form-control" placeholder="Masukan Kata Kunci">
                            <button class="btn btn-primary" name="bcari" type="submit">Cari</button>
                            <button class="btn btn-danger" name="breset" type="submit">Reset</button>
                        </div>
                    </form>
                </div>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th>No.</th>
                        <th>Kode Barang.</th>
                        <th>Nama Barang.</th>
                        <th>Asal Barang.</th>
                        <th>Jumlah.</th>
                        <th>Tanggal Diterima.</th>
                        <th>Aksi.</th>
                    </tr>
                    <?php
                    //persiapkan menampilkan data
                    $no = 1;

                    //untuk pencarian data
                    //jika tombol cari diklik 
                    if (isset($_POST['bcari'])) {
                        //tampilkan data yang di cari
                        $keyword = $_POST['tcari'];
                        $q = "SELECT * FROM tbarang WHERE kode like '%$keyword%' or nama like '%$keyword%'  or asal like '%$keyword%'order by
                        id_barang desc ";

                    } else {
                        $q = "SELECT * FROM tbarang order by id_barang desc";
                    }

                    $tampil = mysqli_query($koneksi, $q);
                    while ($data = mysqli_fetch_array($tampil)):

                        ?>

                        <tr>
                            <td>
                                <?= $no++ ?>
                            </td>
                            <td>
                                <?= $data['kode'] ?>
                            </td>
                            <td>
                                <?= $data['nama'] ?>
                            </td>
                            <td>
                                <?= $data['asal'] ?>
                            </td>
                            <td>
                                <?= $data['jumlah'] ?>
                                <?= $data['satuan'] ?>
                            </td>
                            <td>
                                <?= $data['tanggal_diterima'] ?>
                            </td>
                            <td>
                                <a href="index.php?hal=edit&id=<?= $data['id_barang'] ?>" class="btn btn-warning">Edit</a>

                                <a href="index.php?hal=hapus&id=<?= $data['id_barang'] ?>" class="btn btn-danger"
                                    onclick="return confirm('Apakah anda Yakin akan Hapus Data ini?')">Hapus</a>
                            </td>
                        </tr>

                    <?php endwhile; ?>
                </table>

            </div>
            <div class="card-footer bg-info">

            </div>
        </div>

    </div>

    <!-- <h1>Hello, world!</h1> -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>


<?= template_footer() ?>
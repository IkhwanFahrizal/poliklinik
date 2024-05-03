<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once("../koneksi.php");

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['no_hp'];


    if (isset($_POST['id'])) {
        // Jika ID sudah ada, gunakan UPDATE
        $ubah = mysqli_query($mysqli, "UPDATE dokter SET 
                                            nama = '$nama',
                                            alamat = '$alamat',
                                            no_hp = '$nohp'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
    } else {
        // Jika tidak ada ID, gunakan INSERT
        $tambah = mysqli_query($mysqli, "INSERT INTO dokter (nama, alamat, no_hp) 
                                            VALUES (
                                            '$nama',
                                            '$alamat',
                                            '$nohp'
                                            )");
    }
    echo "<script> 
                document.location='index.php?page=dokter';
                </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
                document.location='index.php?page=dokter';
                </script>";
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
<center><h2>Dokter</h2></center>
<br>
<div class="container">
    <!--Form Input Data-->

    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $nama = '';
        $alamat = '';
        $nohp = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM dokter 
                    WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama = $row['nama'];
                $alamat = $row['alamat'];
                $nohp = $row['no_hp'];
            }
            ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <?php
        }
        ?>
        <div class="row">
            <label for="inputNama" class="form-label fw-bold">
                Nama
            </label>
            <div>
                <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama"
                    value="<?php echo $nama ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputAlamat" class="form-label fw-bold">
                Alamat
            </label>
            <div>
                <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat"
                    value="<?php echo $alamat ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputNohp" class="form-label fw-bold">
                No HP
            </label>
            <div>
                <input type="text" class="form-control" name="no_hp" id="inputNohp" placeholder="No HP"
                    value="<?php echo $nohp ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class=col>
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
            </div>
        </div>
    </form>
    <br>
    <br>
    <!-- Table-->
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Dokter</th>
                <th scope="col">Alamat</th>
                <th scope="col">No. HP</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT * FROM dokter");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th scope="row">
                        <?php echo $no++ ?>
                    </th>
                    <td>
                        <?php echo $data['nama'] ?>
                    </td>
                    <td>
                        <?php echo $data['alamat'] ?>
                    </td>
                    <td>
                        <?php echo $data['no_hp'] ?>
                    </td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3"
                            href="index.php?page=dokter&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3"
                            href="index.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <button class="btn btn-dark" onclick="window.location.href='index.php'">Kembali</button>
    <script>
        function showNotification() {
            alert('Data berhasil disimpan!'); 
        }
    </script>
</body>
<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once("../koneksi.php");

// Ambil data dokter dari database
$query_dokter = "SELECT * FROM dokter";
$result_dokter = mysqli_query($mysqli, $query_dokter);

// Ambil data pasien dari database
$query_pasien = "SELECT * FROM pasien";
$result_pasien = mysqli_query($mysqli, $query_pasien);

if (isset($_POST['simpan'])) {
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $tgl_periksa = $_POST['tgl_periksa'];
    $catatan = $_POST['catatan'];
    $obat = $_POST['obat'];

    if (isset($_POST['id'])) {
        // Jika ID sudah ada, gunakan UPDATE
        $ubah = mysqli_query($mysqli, "UPDATE periksa SET
                                            id_pasien = '$id_pasien',
                                            id_dokter = '$id_dokter',
                                            tgl_periksa = '$tgl_periksa',
                                            catatan = '$catatan',
                                            obat = '$obat'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
    } else {
        // Jika tidak ada ID, gunakan INSERT
        $tambah = mysqli_query($mysqli, "INSERT INTO periksa (id_pasien, id_dokter, tgl_periksa, catatan, obat) 
                                            VALUES (
                                            '$id_pasien',
                                            '$id_dokter',
                                            '$tgl_periksa',
                                            '$catatan',
                                            '$obat'
                                            )");
    }
    echo "<script> 
                document.location='index.php?page=periksa';
                </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
                document.location='index.php?page=periksa';
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
<center><h2>Periksa</h2></center>
<br>
<div class="container">
    <!--Form Input Data-->

    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $id_pasien= '';
        $id_dokter = '';
        $tgl_periksa = '';
        $catatan = '';
        $obat = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM periksa
                    WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $id_pasien = $row['id_pasien'];
                $id_dokter = $row['id_dokter'];
                $tgl_periksa = $row['tgl_periksa'];
                $catatan = $row['catatan'];
                $obat = $row['obat'];
            }
            ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <?php
        }
        ?>
        <div class="row">
            <label for="inputPasien" class="form-label fw-bold">
                Pasien
            </label>
            <div>
                <select class="form-control" name="id_pasien" id="inputPasien" required>
                    <?php while ($row_pasien = mysqli_fetch_assoc($result_pasien)) : ?>
                        <option value="<?php echo $row_pasien['id']; ?>" <?php if ($row_pasien['id'] == $id_pasien) echo 'selected="selected"'; ?>><?php echo $row_pasien['nama']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputDokter" class="form-label fw-bold">
                Dokter
            </label>
            <div>
                <select class="form-control" name="id_dokter" id="inputDokter" required>
                    <?php while ($row_dokter = mysqli_fetch_assoc($result_dokter)) : ?>
                        <option value="<?php echo $row_dokter['id']; ?>" <?php if ($row_dokter['id'] == $id_dokter) echo 'selected="selected"'; ?>><?php echo $row_dokter['nama']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputTglPeriksa" class="form-label fw-bold">
                Tanggal Periksa
            </label>
            <div>
                <input type="date" class="form-control" name="tgl_periksa" id="inputTglPeriksa" placeholder="Tgl Periksa"
                    value="<?php echo $tgl_periksa ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputCatatan" class="form-label fw-bold">
                Catatan
            </label>
            <div>
                <input type="text" class="form-control" name="catatan" id="inputCatatan" placeholder="Catatan"
                    value="<?php echo $catatan ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputObat" class="form-label fw-bold">
                Obat
            </label>
            <div>
                <input type="text" class="form-control" name="obat" id="inputObat" placeholder="Obat"
                    value="<?php echo $obat ?>">
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
                <th scope="col">Pasien</th>
                <th scope="col">Dokter</th>
                <th scope="col">Tgl Periksa</th>
                <th scope="col">Catatan</th>
                <th scope="col">Obat</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT periksa.*, dokter.nama AS nama_dokter, pasien.nama AS nama_pasien FROM periksa LEFT JOIN dokter ON periksa.id_dokter = dokter.id LEFT JOIN pasien ON periksa.id_pasien = pasien.id");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th scope="row">
                        <?php echo $no++ ?>
                    </th>
                    <td>
                        <?php echo $data['nama_pasien'] ?>
                    </td>
                    <td>
                        <?php echo $data['nama_dokter'] ?>
                    </td>
                    <td>
                        <?php echo $data['tgl_periksa'] ?>
                    </td>
                    <td>
                        <?php echo $data['catatan'] ?>
                    </td>
                    <td>
                        <?php echo $data['obat'] ?>
                    </td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3"
                            href="index.php?page=periksa&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3"
                            href="index.php?page=periksa&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
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

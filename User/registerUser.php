<?php
include_once("../koneksi.php");

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['registrasi'])) {
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $confirm_pass = $_POST['confirm_pass'];

    // Memeriksa apakah password dan konfirmasi password sama
    if ($pass !== $confirm_pass) {
        $error = "Konfirmasi password tidak sesuai";
    } else {
        // Menambahkan fungsi password_hash() untuk menghash kata sandi sebelum disimpan
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        // Cek apakah username sudah terdaftar sebelumnya
        $query_check_username = "SELECT * FROM user WHERE username = '$username'";
        $result_check_username = $mysqli->query($query_check_username);

        if ($result_check_username->num_rows > 0) {
            $error = "Username sudah digunakan";
        } else {
            // Query untuk menyimpan data pengguna baru
            $tambah = mysqli_query($mysqli, "INSERT INTO user (username, pass) 
                                                VALUES ('$username', '$hashed_password')");

            // Redirect ke halaman registerUser setelah registrasi
            header("Location: index.php");
            exit();
        }
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center" style="font-weight: bold; font-size: 32px;">Registrasi User</div>
                <div class="card-body">
                    <form method="POST" action="registerUser.php">
                        <?php
                        // Menampilkan pesan kesalahan jika ada
                        if (isset($error)) {
                            echo '<div class="alert alert-danger">' . $error . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                        }
                        ?>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" required
                                placeholder="Masukkan nama anda">
                        </div>
                        <div class="form-group">
                            <label for="pass">Password</label>
                            <input type="password" name="pass" class="form-control" required
                                placeholder="Masukkan kata sandi anda">
                        </div>
                        <div class="form-group">
                            <label for="confirm_pass">Konfirmasi Password</label>
                            <input type="password" name="confirm_pass" class="form-control" required
                                placeholder="Konfirmasi kata sandi anda">
                        </div>
                        <div class="text-center">
                            <p class="mt-3">Sudah Punya Akun? <a href="loginUser.php">Login</a></p>
                            <button type="submit" class="btn btn-primary btn-block" name="registrasi">Registrasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript untuk menampilkan notifikasi registrasi berhasil
    window.onload = function() {
        <?php
        // Cek apakah terjadi registrasi
        if (isset($_POST['registrasi']) && !isset($error)) {
            // Tampilkan notifikasi
            echo 'alert("Registrasi berhasil!");';
        }
        ?>
    }
</script>

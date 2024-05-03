<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['pass']; // Menggunakan 'pass' sebagai nama variabel untuk password

    // Query untuk mencari pengguna berdasarkan username
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = $mysqli->query($query);

    if (!$result) {
        die("Query error: " . $mysqli->error);
    }

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Memeriksa apakah password yang dimasukkan cocok dengan hash yang tersimpan di database
        if (password_verify($password, $row['pass'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit(); // Pastikan untuk menghentikan eksekusi skrip setelah melakukan pengalihan header
        } else {
            $error = "Password salah";
        }
    } else {
        $error = "User tidak ditemukan";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center" style="font-weight: bold; font-size: 32px;">Login User</div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=loginUser">
                        <?php
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
                        <div class="form-group" style="padding-bottom: 20px">
                            <label for="password">Password</label>
                            <input type="password" name="pass" class="form-control" required
                                placeholder="Masukkan kata sandi anda">
                        </div>
                        <div class="text-center">
                            <p class="mt-3">Belum punya akun? <a href="index.php?page=registerUser">Register</a></p>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

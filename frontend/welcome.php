<?php

include '../conn/config.php';

session_start();

//redirect
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style_3.css">
</head>

<body>
    <div class="container">
        <div class="welcome-user">
            <h1> Welcome! </h1>
            <?php
            echo $_SESSION['username'];
            ?>
            <div class="ucapan-selamat">Selamat kamu berhasil Login</div>
            <div class="input-group">
                <button onclick="location.href='halaman-utama.php'" class="btn">
                    <a href="halaman-utama.php">Kembali ke beranda</a>
                </button>
            </div>
        </div>
</body>

</html>
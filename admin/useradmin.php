<?php
if (isset($_POST['tambahuser'])) {

    global $conn;

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "INSERT INTO administrator (Nama, username, password) VALUES ('$nama', '$username', '$password')";
    $result = mysqli_query($conn, $sql);
    $message = '';
    if ($result) {
        $message = "Data administrator berhasil ditambahkan";
    } else {
        $message = "Terjadi kesalahan: " . mysqli_error($conn);
    }

    echo '<div class="notification">' . $message . '</div>';
    echo '<script type="text/javascript">
            var notification = document.querySelector(".notification");
            notification.style.display = "block";
            setTimeout(function() {
                notification.style.display = "none";
            }, 5000);
        </script>';
}

if (isset($_GET['act']) && $_GET['act'] == 'edit') {
    $act = $_GET['act'];
    $id = (int)$_GET['id'];

    $sql = mysqli_query($conn, "SELECT * FROM administrator WHERE id = '$id' ");
    $b = mysqli_fetch_array($sql, MYSQLI_ASSOC);
}

if (isset($_GET['act']) && $_GET['act'] == 'hapus') {
    $act = $_GET['act'];
    $id = (int)$_GET['id'];

    $sql = "DELETE FROM administrator WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);
    $message = '';
    if ($result) {
        $message = "Data administrator berhasil dihapus.";
    } else {
        $message = "Terjadi kesalahan: " . mysqli_error($conn);
    }

    echo '<div class="notification">' . $message . '</div>';
    echo '<script type="text/javascript">
            var notification = document.querySelector(".notification");
            notification.style.display = "block";
            setTimeout(function() {
                notification.style.display = "none";
            }, 5000);
        </script>';
}

if (isset($_POST['edituser'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $sql = "UPDATE administrator SET username='" . $username . "', Nama ='" . $_POST['nama'] . "'
    WHERE id= '" . $_POST['userid'] . "' ";
    $result = mysqli_query($conn, $sql);
    $message = '';
    if ($result) {
        $message = "Data administrator berhasil diupdate";
    } else {
        $message = "Terjadi kesalahan: " . mysqli_error($conn);
    }

    echo '<div class="notification">' . $message . '</div>';
    echo '<script type="text/javascript">
            var notification = document.querySelector(".notification");
            notification.style.display = "block";
            setTimeout(function() {
                notification.style.display = "none";
            }, 5000);
        </script>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="./?mod=useradmin" method="POST">
        <input type="hidden" name="userid" value="<?= $b['id'] ?>">
        <fieldset class="form-group border p-4">
            <legend class="w-auto px-1"><?= isset($b['id']) ? 'Edit User Admin' : 'Tambah User Admin' ?></legend>

            <div class="form-field">
                <label for="nama">Nama User</label>
                <input type="text" id="nama" name="nama" placeholder="Nama Lengkap" class="form-control" value="<?= isset($b['Nama']) ? $b['Nama'] : '' ?>">
            </div>

            <div class="form-field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" class="form-control" value="<?= isset($b['username']) ? $b['username'] : '' ?>">
            </div>

            <div class="form-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>

            <input type="submit" name="<?= isset($b['id']) ? 'edituser' : 'tambahuser' ?>" value="<?= isset($b['id']) ? 'Edit' : 'Tambah' ?>" class="btn btn-success mt-3">
        </fieldset>
    </form>



    <br>
    <fieldset>
        <legend>List User</legend>
        <div class="user-list">
            <hr>
            <div class="row header-row">
                <div class="column w10 bold">No.</div>
                <div class="column w20 bold">Username</div>
                <div class="column w20 bold">Nama</div>
                <div class="column w20 bold">Aksi</div>
            </div>
            <hr>

            <?php

            $i = 1; 
            $Kategori = "useradmin";
            $sql = mysqli_query($conn, "SELECT * FROM administrator ORDER BY id ASC");
            while ($r = mysqli_fetch_array($sql)) {
                extract($r);

                echo
                '<div class="row">
                <div class="column w10">' . $i++ . '</div>
                <div class="column w20">' . $username . '</div>
                <div class="column w20">' . $Nama . '</div>
                <div class="column w20">
                <a href="?mod=useradmin&act=edit&id=' . $id . '" style="font-size: 15px; padding: 2px 5px; border-radius: 4px" class="tombol-edit">Edit</a> |
                <button class="tombol-delete" style="font-size: 15px; padding: 2px 5px; border-radius: 4px" onclick="showConfirmation2(' . $id . ',`useradmin`)">Hapus</button></div>
            </div>';
            }
            ?>

            <!-- Pop-up -->
            <div id="popup" class="popup">
                <div class="popup-content">
                    <p>Apakah Anda yakin ingin menghapus data administrator ini?</p>
                    <a id="confirm-button" class="popup-button">Ya</a>
                    <button class="popup-button" onclick="hideConfirmation()">Batal</button>
                </div>
            </div>
        </div>
    </fieldset>

    <script src="../js/script.js"></script>
    <script src="../js/script2.js"></script>

</body>

</html>
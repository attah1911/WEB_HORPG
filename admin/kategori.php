<?php

if (isset($_POST['tambahkategori'])) {
    global $conn;

    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $alias = mysqli_real_escape_string($conn, $_POST['alias']);
    $terbit = mysqli_real_escape_string($conn, $_POST['terbit']);

    $sql = "INSERT INTO kategori (Kategori, alias, Terbit) VALUES ('$kategori', '$alias', '$terbit')";
    $result = mysqli_query($conn, $sql);
    $message = '';
    if ($result) {
        $message = "Kategori berhasil ditambahkan";
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

    $sql = mysqli_query($conn, "SELECT * FROM kategori WHERE ID = '$id' ");
    $b = mysqli_fetch_array($sql, MYSQLI_ASSOC);
}

if (isset($_GET['act']) && $_GET['act'] == 'hapus') {
    $act = $_GET['act'];
    $id = (int)$_GET['id'];

    $sql = "DELETE FROM kategori WHERE ID = '$id' ";
    $result = mysqli_query($conn, $sql);
    $message = '';
    if ($result) {
        $message = "Kategori berhasil dihapus.";
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

if (isset($_POST['editkategori'])) {
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);

    $sql = "UPDATE kategori SET Kategori='" . $kategori . "', alias ='" . $_POST['alias'] . "'
    WHERE ID= '" . $_POST['userid'] . "' ";
    $result = mysqli_query($conn, $sql);
    $message = '';
    if ($result) {
        $message = "Kategori berhasil diupdate";
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
    <form action="./?mod=kategori" method="POST">
        <input type="hidden" name="userid" value="<?= $b['ID'] ?>">
        <fieldset class="form-group border p-4">
            <legend class="w-auto px-1"><?= isset($b['ID']) ? 'Edit Kategori' : 'Tambah Kategori' ?></legend>

            <div class="form-field">
                <label for="nama">Kategori</label>
                <input type="text" id="kategori" name="kategori" placeholder="Nama Kategori" class="form-control" value="<?= isset($b['Kategori']) ? $b['Kategori'] : '' ?>">
            </div>

            <div class="form-field">
                <label for="nama">Alias</label>
                <input type="text" id="alias" name="alias" placeholder="Alias" class="form-control" value="<?= isset($b['alias']) ? $b['alias'] : '' ?>">
            </div>

            <div class="form-field">
                <label for="nama">Tampilkan : </label>
                <select name="terbit" id="terbit">
                    <option value="1" <?= (isset($b['Terbit']) == 1 ? 'selected' : ''); ?>>Yes</option>
                    <option value="0" <?= (isset($b['Terbit']) == 0 ? 'selected' : ''); ?>>No</option>
                </select>
            </div>
            <input type="submit" name="<?= isset($b['ID']) ? 'editkategori' : 'tambahkategori' ?>" value="<?= isset($b['ID']) ? 'Edit' : 'Tambah' ?>" class="btn btn-success mt-3">
        </fieldset>
    </form>


    <br>
    <fieldset>
        <legend>List Kategori</legend>
        <div class="user-list">
            <hr>
            <div class="row header-row">
                <div class="column w10 bold">No.</div>
                <div class="column w20 bold">Kategori</div>
                <div class="column w20 bold">Alias</div>
                <div class="column w20 bold">Aksi</div>
            </div>
            <hr>

            <?php
            global $conn;
            $i = 1; 

            $hasil = mysqli_query($conn, "SELECT * FROM kategori ORDER BY ID ASC");
            while ($r = mysqli_fetch_array($hasil)) {
                extract($r);
            ?>
                <div class="row header-row">
                    <div class="column w10"><?= $i++; ?></div>
                    <div class="column w20"><?= $Kategori; ?></div>
                    <div class="column w20"><?= $alias; ?></div>
                    <div class="column w20">
                        <a href="./?mod=kategori&act=edit&id=<?= $ID; ?>" class="tombol-edit" style="font-size: 15px; padding: 2px 5px;">Edit</a> |
                        <?php
                        echo '<button class="tombol-delete" style="font-size: 15px; padding: 2px 5px; border-radius: 4px" onclick="showConfirmation2(' . $ID . ',`kategori`)">Hapus</button>'
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <!-- Pop-up -->
        <div id="popup" class="popup">
            <div class="popup-content">
                <p>Apakah Anda yakin ingin menghapus Kategori ini?</p>
                <a id="confirm-button" class="popup-button">Ya</a>
                <button class="popup-button" onclick="hideConfirmation()">Batal</button>
            </div>
        </div>
    </fieldset>

    <script src="../js/script.js">

    </script>
    <script src="../js/script2.js">

    </script>
</body>

</html>
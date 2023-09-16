<?php

error_reporting(0);

if (isset($_POST['add'])) {
    if (!empty($_FILES['gambar']['name']) && ($_FILES['gambar']['error'] !== 4)) {

        $gambarfile = $_FILES['gambar']['tmp_name'];
        $gambarfile_name = $_FILES['gambar']['name'];
        $filetype = $_FILES['gambar']['type'];
        $allowtype = array('image/jpeg', 'image/jpg', 'image/png');

        if (!in_array($filetype, $allowtype)) {
            echo 'Invalid file type';
            exit;
        }

        $path = PATH_GAMBAR . '/';

        if ($gambarfile && $gambarfile_name) {

            $gambarbaru = preg_replace("/[^a-zA-Z0-9]/", "_", $_POST['judul']);
            $dest1 = '../' . $path . $gambarbaru . '.jpg';
            $dest2 = $path . $gambarbaru . '.jpg';

            copy($_FILES['gambar']['tmp_name'], $dest1);

            $gambar = $dest2;
        } else {
            $gambar = $_POST['gambar'];
        }
    }

    if ($_POST['act'] == 'tambah') {
        global $conn;
        $sql = "INSERT INTO berita (Judul,Isi,Kategori,Gambar,Teks,Tanggal,View,Author,Post_type,Terbit) 
                VALUES 
                ('" . $_POST['judul'] . "',
                '" . $_POST['isi'] . "',
                '" . $_POST['kategori'] . "',
                '$gambar',
                '" . $_POST['teks'] . "',
                '" . date("Y-m-d H:i:s") . "',
                '0',
                '" . $_SESSION['Nama'] . "',
                'berita',
                '" . $_POST['terbit'] . "')";

        $hasil = mysqli_query($conn, $sql);
    }

    if ($_POST['act'] == 'edit') {
        global $conn;

        $sql = mysqli_query($conn, "UPDATE berita SET 
        Judul = '" . $_POST['judul'] . "',
        Isi = '" . $_POST['isi'] . "',
        Kategori = '" . $_POST['kategori'] . "',
        " . (!empty($gambar) ? " Gambar = '$gambar'," : "") . "
        Teks = '" . $_POST['teks'] . "',
        Terbit = '" . $_POST['terbit'] . "' 
        WHERE ID='" . $_POST['id'] . "'");
    }
}

$terbit = 1;
if (isset($_GET['act']) && $_GET['act'] == 'edit') {
    global $conn;

    $id = (int)$_GET['id'];
    $sql = mysqli_query($conn, "SELECT * FROM berita WHERE ID = '$id' ");
    if ($sql) {
        while ($b = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
            extract($b);

            $id = $ID;
            $judul = $Judul;
            $kategori = $Kategori;
            $isi = $Isi;
            $gambar = $Gambar;
            $teks = $Teks;
            $tanggal = $Tanggal;
            $author = $Author;
            $terbit = $Terbit;

            if (isset($_GET['hapusgambar']) && $_GET['hapusgambar'] == 'yes') {
                unlink('../' . $gambar);
                $sqlupdate = mysqli_query($conn, "UPDATE berita SET Gambar = '' WHERE ID = '$id' ");
                echo '<meta http-equiv="REFRESH" content="0;url=./?mod=berita&act=edit&id=' . $id . '" />';
            }
        }
    } else {
        echo "Error in SQL query: " . mysqli_error($conn);
    }
}

if (isset($_GET['act']) && $_GET['act'] == 'hapus') {
    global $conn;
    $id = (int)$_GET['id'];

    $sql = mysqli_query($conn, "SELECT * FROM berita WHERE ID = '$id' ");
    if ($sql) {
        while ($b = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
            $gbr = $b['Gambar'];
            if (!empty($gbr)) {
                unlink('../' . $gbr);
            }
        }
        $hapus = mysqli_query($conn, "DELETE FROM berita WHERE ID = '$id' ");
    }
}

if (isset($_GET['act']) && $_GET['act'] == 'hapus') {
    $act = $_GET['act'];
    $id = (int)$_GET['id'];

    $sql = "DELETE FROM berita WHERE ID = '$id' ";
    $result = mysqli_query($conn, $sql);
    $message = '';
    if ($result) {
        $message = "Berita berhasil dihapus.";
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                tabsize: 2,
                height: auto,
            });
        });
    </script>

    <title>Document</title>

</head>

<body>
    <form action="./?mod=berita" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
        <input type="hidden" name="act" value="<?= isset($id) ? 'edit' : 'tambah' ?>">
        <fieldset class="form-group border p-4">
            <legend class="w-auto px-1"><?= isset($id) ? 'Edit Berita' : 'Tambah Berita' ?></legend>

            <div class="form-field">
                <label for="nama">Judul</label><br>
                <input type="text" name="judul" placeholder="Judul Berita" value="<?= isset($judul) ? $judul : '' ?>" class="form-control">
            </div>

            <div class="form-field">
                <label for="nama">Kategori</label><br>
                <select name="kategori">
                    <option>Pilih Kategori</option>
                    <?php
                    global $conn;
                    $hasil = mysqli_query($conn, "SELECT * FROM kategori WHERE Terbit='1' ORDER BY ID DESC");
                    while ($k = mysqli_fetch_array($hasil)) {

                        echo '<option value="' . $k['alias'] . '" ' . ($kategori == $k['alias'] ? 'selected' : '') . ' > ' . $k['Kategori'] . ' </option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-field">
                <label for="nama">Isi Berita</label><br>
                <textarea name="isi" cols="80" rows="8" class="summernote"><?= isset($isi) ? $isi : '' ?></textarea>
            </div>

            <div class="form-field">
                <label for="nama">Gambar</label>
                <?php
                if (isset($gambar) && !empty($gambar) && isset($id)) {
                    echo '
                    <div class="imgsedang">
                        <input type="hidden" name="gambar" value="' . $gambar . '">
                        <img src="' . URL_SITUS . $gambar . '" width="200">
                        <br>
                        <br> 
                        <div class="imghapus">
                            <a href="./?mod=berita&act=edit&hapusgambar=yes&id=' . $ID . '"> x </a>
                        </div>
                    </div>
                ';
                } else {
                    echo '<input type="file" name="gambar">';
                }
                ?>
            </div>
            <div class="clear"></div>
            <div class="form-field">
                <label for="nama">Teks</label><br>
                <textarea name=teks cols="30" rows="5"><?= isset($teks) ? $teks : '' ?></textarea>
            </div>

            <div class="form-field">
                <label for="nama">Terbitkan : </label><br>
                <select name="terbit" id="terbit">
                    <option value="1" <?= $terbit == 1 ? 'selected' : '' ?>>Yes</option>
                    <option value="0" <?= $terbit == 0 ? 'selected' : '' ?>>No</option>
                </select>
            </div>

            <input type="submit" name="add" value="<?= isset($id) ? 'Edit' : 'Tambah' ?>" class="btn btn-success mt-3">
        </fieldset>
    </form>

    <fieldset>
        <legend>
            List Berita
        </legend>
        <div class="user-list">
            <hr>
            <div class="row header-row">
                <div class="column w10 bold">No.</div>
                <div class="column w10 bold">Judul</div>
                <div class="column w10 bold">Kategori</div>
                <div class="column w20 bold">Tanggal</div>
                <div class="column w20 bold">Aksi</div>
            </div>
            <hr>
            <?php
            global $conn;
            $i = 1; // Mengubah i mulai dari 1

            $hasil = mysqli_query($conn, "SELECT * FROM berita ORDER BY ID ASC");
            while ($b = mysqli_fetch_array($hasil)) {
                extract($b);
            ?>
                <div class="row header-row">
                    <div class="column w10"><?= $i++; ?></div>
                    <div class="column w10"><?= $Judul; ?></div>
                    <div class="column w10"><?= $Kategori; ?></div>
                    <div class="column w20"><?= $Tanggal; ?></div>
                    <div class="column w20">
                        <a href="./?mod=berita&act=edit&id=<?= $ID; ?>" class="tombol-edit" style="font-size: 15px; padding: 2px 5px;">Edit</a> |
                        <?php
                        echo '<a class="tombol-delete" style="font-size: 15px; padding: 2px 5px;" onclick="showConfirmation2(' . $ID . ',`berita`)">Hapus</a>';
                        ?>

                    </div>
                </div>
            <?php
            }
            ?>

            <!-- Pop-up -->
            <div id="popup" class="popup">
                <div class="popup-content">
                    <p>Apakah Anda yakin ingin menghapus Berita ini?</p>
                    <a id="confirm-button" class="popup-button">Ya</a>
                    <button class="popup-button" onclick="hideConfirmation()">Batal</button>
                </div>
            </div>
    </fieldset>

    <script src="../js/script.js"></script>
    <script src="../js/script2.js"></script>
</body>

</html>
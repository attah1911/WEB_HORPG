<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style6.css">
</head>

<body>
    <form method="post" id="komentarForm">
        <div class="komentar_1">
            <!-- Input untuk memasukkan nama -->
            <label style="font-size: 15px; color: #333;">Username :</label>
            <input class="edit_input" type="text" name="nama" placeholder="Masukkan Nama" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>" readonly> <br>

            <!-- Textarea untuk memasukkan isi komentar -->
            <textarea name="isi" rows="10" placeholder="Masukkan Isi Komentar"></textarea> <br>

            <!-- Tombol untuk mengirim komentar -->
            <button type="submit" name="btnkomen">Submit</button>
        </div>
    </form>

    <?php
    if (isset($_POST['btnkomen'])) {
        $nama = $_POST['nama'];
        $isi = $_POST['isi'];
        $tgl = date("d-m-Y");

        $sql = "INSERT INTO komentar VALUES('', '$id', '$nama', '$tgl', '$isi')";
        $que = mysqli_query($conn, $sql);
        echo "<meta http-equiv='refresh' content='1;url=detail.php.php?detail=" . $id . "'>";
    }

    ?>

    <?php
    include '../conn/config.php';
    $id = $_GET['detail'];
    $sql = "SELECT * FROM komentar WHERE id_art = '$id' ";
    $que = mysqli_query($conn, $sql);
    while ($res = mysqli_fetch_array($que)) {
    ?>
        <div class="komentar_box" id=komentarTrending>
            <div class="isi_komen">
                <p class="nama"><?php echo $res['username']; ?></p>
                <p class="tanggal"><?php echo $res['tanggal']; ?></p>
                <p class="isi"><?php echo $res['isi_komentar']; ?></p>
            </div>
        </div>

    <?php
    }
    ?>
    <script src="../js/script.js">       
    </script>

</body>

</html>
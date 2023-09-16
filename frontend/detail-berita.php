<?php
include '../conn/config.php';

session_start();
define("URL_SITUS", "http://localhost/project_webapp/");
define("PATH_GAMBAR", "photo");

//redirect
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FEATRES ICON -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@100;200;300;400;500;600;700;800&family=Lexend+Deca:wght@600;700;800;900&family=Mukta:wght@300;400;500;600;700;800&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="../css/style_5.css">
    <link rel="stylesheet" href="../css/style.css">

    <title>Document</title>
</head>

<body>

    <!--NAv BAR-->
    <nav class="navbar">
        <a href="halaman-utama.php" class="navbar-logo"><span>HO</span>RPG.</a>
        <div class="navbar-isi">
            <a href="halaman-utama.php#home">HOME</a>
            <a href="halaman-utama.php#trending">TRENDING</a>
            <a href="halaman-utama.php#berita">BERITA</a>
            <a href="halaman-utama.php#list">LIST GAME</a>
            <a href="halaman-utama.php#SOCIAL">SOCIAL</a>
        </div>

        <div class="navbar-tambahan">
            <!--logout-->
            <div class="input-group">
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<span class="user-name">Welcome ' . $_SESSION['username'] . ' !</span>';
                }
                ?>
                <form method="POST" action="">
                    <button name="logout" type="submit" class="tombol"><a>Logout</a></button>
                </form>
            </div>
            <!--menubar-->
            <a href="#" id="menuBar"><i data-feather="menu"></i></a>
        </div>
    </nav>
    <!--NAV END-->

    <?php
    global $conn;
    if (isset($_GET['detail-berita'])) {
        $id = $_GET['detail-berita'];
        $sql = "SELECT * FROM berita WHERE Terbit = '1' AND ID = '$id'";
        $que = mysqli_query($conn, $sql);

        if ($que) {
            while ($b = mysqli_fetch_array($que)) {

                $Updateview = mysqli_query($conn, "UPDATE berita SET View=View+1 WHERE ID = '$id'")
    ?>
                <br>
                <br>
                <br>
                <br>
                <br>
                <div class="kotak">
                    <h1>
                        <?php echo $b['Judul']; ?>
                    </h1>
                    <div class="info">
                        <span>
                            Tanggal: <?php echo $b['Tanggal']; ?>
                        </span>|
                        <span>
                            Update by: <?php echo $b['Author']; ?>
                        </span>
                    </div>
                    <p>
                        <?php echo nl2br($b['Isi']); ?>
                    </p>
                    <div class="clear"></div>
                </div>
                <br>
                <br>
                <h1 style="margin-left: 290px;"> Silahkan berkomentar dengan bijak! </h1>
                <?php
                include 'komen-berita.php';
                ?>

    <?php
            }
        } else {
            echo "Error in SQL query: " . mysqli_error($conn);
        }
    }
    ?>
    <script>
        feather.replace()
    </script>

    <script src="../js/script.js"></script>

</body>

</html>
<?php
include '../conn/config.php';

session_start();

define("URL_SITUS", "http://localhost/project_webapp/");
define("PATH_GAMBAR", "photo");

//redirect
if (!isset($_SESSION['username'])) {
    // Pengguna belum login, arahkan kembali ke halaman login.php
    header("Location: login.php");
    exit();
}

//logout
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
    <title>WEB AKhir</title>


    <!-- FEATRES ICON -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@100;200;300;400;500;600;700;800&family=Lexend+Deca:wght@600;700;800;900&family=Mukta:wght@300;400;500;600;700;800&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <!--NAv BAR-->
    <nav class="navbar">
        <a href="#" class="navbar-logo"><span>HO</span>RPG.</a>

        <div class="navbar-isi">
            <a href="#home">HOME</a>
            <a href="#trending">TRENDING</a>
            <a href="#berita">BERITA</a>
            <a href="#list">LIST GAME</a>
            <a href="#SOCIAL">SOCIAL</a>
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

    <!--Hero Section-->
    <section class="hero" id="home">
        <main class="content">
            <h2><span>HO</span>RPG.</h2>
            <p>HOUSE OF RPG adalah situs yg dibuat untuk para komunitas game rpg<br>di seluruh indonesia, yang terbentuk untuk mengumpulkan informasi <br>apa saja yang para pemain game rpg dapatkan selama ini</p>

        </main>
    </section>

    <!--Hero Section-->

    <!-- TRENDING & BERITA MULAI -->
    <sec id="trending" class="container-trending">
        <h1><span>TR</span>ENDING</h1>
        <br>
        <br>
        <div class="kontainer">
            <?php
            include '../conn/config.php';
            $sql = "SELECT * FROM artikel";
            $hasil = mysqli_query($conn, $sql);
            $jmlArtikel = mysqli_num_rows($hasil);
            if ($jmlArtikel > 0) {
                while ($row = mysqli_fetch_assoc($hasil)) {
            ?>
                    <div class="card">
                        <div class="header">
                            <?= $row["image"]; ?>
                        </div>
                        <div class="info">
                            <p class="title">
                                <?= $row["judul"]; ?>
                            </p>
                        </div>
                        <div class="footer">
                            <p>
                            </p>
                            <button onclick='location.href="detail.php?detail=<?php echo $row["id_artikel"]; ?>"' class="btn">
                                <a href="detail.php?detail=<?php echo $row["id_artikel"]; ?>">
                                    Baca selengkapnya
                                </a>
                            </button>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </sec>

    <sec id="berita" class="container-trending">
        <h1><span>BE</span>RITA</h1>
        <br>
        <br>
    </sec>
    <div class="mainpage">
        <div class="content_berita">
            <?php
            global $conn;

            $sql = "SELECT * FROM berita WHERE Terbit = '1' ORDER
                    BY ID ASC LIMIT 0,10";
            $hasil = mysqli_query($conn, $sql);
            $jmlBerita = mysqli_num_rows($hasil);
            if ($jmlBerita > 0) {
                while ($b = mysqli_fetch_assoc($hasil)) {
                    extract($b);
            ?>
                    <div class="boxnews">
                        <div class="img">
                            <img src="<?= URL_SITUS . $Gambar ?>">
                        </div>
                        <div class="info-berita">
                            <h1 class="title-berita">
                                <a href="detail-berita.php?detail-berita=<?php echo $b["ID"]; ?>"><?= $b['Judul'] ?></a>
                            </h1>
                            <p>
                                <?= substr(strip_tags($Isi), 0, 300) ?>
                            </p>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <div class="sidebar">
            <div class="card-kecil left-position">
                <div class="card-kecil-populer">
                    <div class="header-kecil-populer"></div>
                    <div class="card-teks-populer">
                        <h3>Berita Populer</h3>
                    </div>
                </div>

                <?php
                global $conn;

                $pop = mysqli_query($conn, "SELECT * FROM berita WHERE Terbit = '1' AND Tanggal >='" . date('Y-m-d H:i:s', strtotime('-7 days')) . "'
                    AND Tanggal >= '" . date("Y-m-d H:i:s", strtotime('-7days')) . "'
                    ORDER BY View DESC LIMIT 0,10");

                while ($r = mysqli_fetch_array($pop)) {
                    extract($r);

                    echo '
                    <div class="card-berita-kecil">
                        <img src="' . URL_SITUS . $Gambar . '">
                        <div class="info-berita-kecil>
                            <span class="view-berita" style="color: #333; margin-left: 5px;">' . substr($Tanggal, 0, 10) . ' | View: <b>' . $View . '</b></span>
                            <div class="card-text-kecil">
                                <h1><a href="detail-berita.php?detail-berita=' . $ID . ' ">' . $Judul . '</a></h1>
                            </div>
                        </div>
                    </div>
                    ';
                }
                ?>

            </div>
        </div>
    </div>

    <!-- TRENDING & BERITA MULAI -->

    <br>
    <br>
    <br>

    <!-- List Game mulai**************************************************************************-->
    <section id="list" class="list">
        <h1>LIST<span>GAME</span></h1>
        <br>
        <br>

        <ul class="gallery">
            <li class="image1">
                <a href="https://ragnarok-origin.com/" target="_blank">
                    <img src="../img/ragnarog.jpeg">
                </a>
            </li>
            <li class="image2">
                <a href="http://www.monsterhunterworld.com/us/">
                    <img src="../img/monter_hunter.jpeg" alt="monter_hunter">
                </a>
            </li>
            <li class="image3">
                <a href="https://www.sea.playblackdesert.com/en-US/Main/Index" target="_blank">
                    <img src="../img/blackDesert.jpg">
                </a>
            </li>
            <li class="image4">
                <a href="https://genshin.hoyoverse.com/id/" target="_blank">
                    <img src="../img/gensin.jpeg">
                </a>
            </li>
        </ul>
    </section>

    <section id="SOCIAL" class="sosial">
        <h1>SO<span>CIAL</span></h1>
        <br>
        <br>

        <div class="image-container">
            <div class="gambar1">
                <img src="../img/gambar_wa.jpg" alt="Gambar 1" class="taller-image">
                <p class="text1"><button id="whatsappBtn"><a href="https://chat.whatsapp.com/IJX1WpleDiR0ENnNrOIwmT" target="_blank">WhatsApp</a></button></p>
            </div>

            <div class="gambar2">
                <img src="../img/gambar_dc.jpg" alt="Gambar 2" class="fade-image">
                <p class="text2"><button id="discordBtn"><a href="https://discord.gg/Nu4899hwEH" target="_blank">Discord</a></button></p>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </section>

    <div class="lisensi">
        <br>
        <p>Copyright © Jakastat Co., Hatta gymnastyar,Azmi,Rifqi(studio DTDS). All Rights Reserved</p>
        <br>
        <br>
    </div>
    <!--AKHIR********************************************************************************-->

    <!-- FEATERS ICON -->
    <script>
        feather.replace()
    </script>

    <script src="../js/script.js"></script>

</body>

</html>
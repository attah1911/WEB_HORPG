<?php
include '../conn/config.php';

session_start();
define("URL_SITUS", "http://localhost/project_webapp/");
define("PATH_GAMBAR", "photo");

//redirect
if (!isset($_SESSION["Nama"])) {
  echo "<script>
    if(!alert('Anda belum login')) {
      window.location.href = './checklog.php';
    }
  </script>";
}

if (isset($_POST['logout'])) {
  session_unset();
  session_destroy();
  header("Location: checklog.php");
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- include libraries(jQuery, bootstrap) -->
  <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <script type="text/javascript" src="cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- include summernote css/js-->
  <link href="summernote-bs5.css" rel="stylesheet">
  <script src="summernote-bs5.js"></script>
  <script>
    $(document).ready(function() {
      $('.summernote').summernote();
    });
  </script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style_7.css">
  <title>Admin Dashboard</title>
</head>

<body>

  <div id="content-container">
    <div id="sidebar">

      <h1>Admin Dashboard</h1>
      <div>
        <label>
          Halo! admin
        </label>
        <?php
        echo $_SESSION['Nama'];
        ?>
      </div>
      <hr>
      <div class="menu-item"><a href="index.php">Dashboard</a></div>
      <div class="menu-item"><a href="?mod=berita">Berita</a></div>
      <div class="menu-item"><a href="?mod=kategori">Kategori</a></div>
      <div class="menu-item"><a href="?mod=useradmin">Pengaturan</a></div>
      <div class="menu-item">
        <form method="POST" action="">
          <button name="logout" type="submit" class="tombol-delete"><a>Logout</a></button>
        </form>
      </div>
    </div>
  </div>


  <div id="content">
    <?php
    if (isset($_GET['mod'])) {
      $mod = $_GET['mod'];

      switch ($mod) {
        case 'useradmin':
          include 'useradmin.php';
          break;

        case 'kategori':
          include 'kategori.php';
          break;

        case 'berita':
          include 'berita.php';
          break;

        default:
          break;
      }
    } else {
      // kosong
    }
    ?>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    document.querySelector('.menu-item:last-child a').addEventListener('click', () => {
      sidebar.classList.toggle('sidebar-closed');
    });
  </script>
</body>

</html>
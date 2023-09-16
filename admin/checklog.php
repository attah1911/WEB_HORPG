<?php
include '../conn/config.php';

session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek admin
    $admin_sql = "SELECT * FROM administrator WHERE username='$username' AND password='$password'";
    $admin_result = mysqli_query($conn, $admin_sql);
    $message = '';
    if ($admin_result->num_rows > 0) {
        $admin_row = mysqli_fetch_assoc($admin_result);
        $_SESSION['Nama'] = $admin_row['Nama'];
        header("Location: index.php");
        exit();
    } else {
        $message = "Username atau Password salah. ";
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
    <title>LOGIN ADMIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style_8.css">
</head>

<body>
    <div class="loginpage">
        <a href="#" class="navbar-logo"><span>HO</span>RPG.</a>
        <br>
        <label> ADMINISTRATOR </label>
        <form action="" method="POST" class="login-email" id="login.php">
            <div class="username-login">
                <label>Username</label>
                <input type="text" name="username" placeholder="username">

                <label>Password</label>
                <input type="password" name="password">

                <div class="input-group">
                    <button name="submit" class="btn">Login</button>
                </div>
            </div>
        </form>
    </div>
    <script src="../js/script.js">
    </script>
</body>

</html>
<?php

include '../conn/config.php';

error_reporting(0);

session_start();

// proses register
if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);

	if ($password == $cpassword) {
		$sql = "SELECT * FROM users WHERE email = '$email'";
		$result = mysqli_query($conn, $sql);
		if (!$result->num_rows > 0) {
			if (preg_match('/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/', $username)) {
				$sql = "INSERT INTO users (username, email, password)
						VALUES ('$username', '$email', '$password')";
				$result = mysqli_query($conn, $sql);
				if ($result) {
					echo "<script>alert('Registrasi Berhasil!')</script>";
					$username = "";
					$email = "";
					$_POST['password'] = "";
					$_POST['cpassword'] = "";
				}
			} else {
				echo "<script>alert('Username harus terdiri dari huruf dan angka.')</script>";
			}
		} else {
			echo "<script>alert('Email sudah terdaftar')</script>";
		}
	} else {
		echo "<script>alert('Password tidak sesuai')</script>";
	}
}

	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="../css/style_2.css">

	<title>Register Form </title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Sign Up</p>
			<div class="input-group">
				<input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn" id="registrasiButton">Sign Up</button>
			</div>
			<p class="login-register-text">Have an account? <a href="login.php">Login Here</a>.</p>
		</form>
	</div>
	<script src="../js/script.js"></script>
</body>
</html>

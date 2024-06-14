<?php

// Sertakan file functions.php
require_once '../../functions/functions.php';




// Tangani submit formulir login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['login'])) {
      // Tombol login ditekan
      if (login()) {
          // Login berhasil, hapus isi formulir login
          unset($_POST['username']);
          unset($_POST['password']);
		  $userip = $_SERVER['REMOTE_ADDR'];
		  $_POST[$userip];
      }
  } elseif (isset($_POST['signup'])) {
      // Tombol signup ditekan
      if (register()) {
          // Registrasi berhasil, hapus isi formulir signup
          unset($_POST['username']);
          unset($_POST['role']);
          unset($_POST['password']);
		  $userIp = $_SERVER['REMOTE_ADDR'];
      }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Login</title>
	<link rel="stylesheet" type="text/css" href="../../assets/css/login.css">
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
	<script src="../../assets/js/login.js"></script>
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form method="post">
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="username" placeholder="User name" required="">
					<select name="role" required>
						<option value="" disabled selected>Pilih Role</option>
						<option value="admin">Admin</option>
						<option value="kasir">Kasir</option>
						<option value="gudang">Gudang</option>
					</select>
					<input type="password" name="password" placeholder="Password" required="">
					<button type="submit" name="signup">Sign up</button>
				</form>
			</div>

			<div class="login">
				<form method="post">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="text" name="username" placeholder="User name" required="">
					<input type="password" name="password" placeholder="Password" required="">
					<button type="submit" name="login">Login</button>
				</form>
			</div>
	</div>
</body>
</html>
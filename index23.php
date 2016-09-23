<?php
require_once "engine/init.php";
$helper->logged_in_protect();
if(isset($_POST["btnSubmit"])) {
	$login = $pengguna->login($_POST["username"],$_POST["password"]);
	if($login === true) {
		header("location: home");
		exit();
	} else {
		$helper->set_flashdata("red","Periksa ulang username dan password anda!<br /> Jika masih tidak bisa, kemungkinan status anda sebagai user sudah diblokir");
		header("location: index");
		exit();
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Tplt v3 Beta</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
	</head>
	<body style="background-image: url(img/bg.png);background-size: cover" onload="loginform.username.focus()">
		<?php $helper->get_notif();?>
		<div class="side-bend">
			<h1>Tplt BackEnd v3 Beta</h1>
			<div class="login-form">
				<form method="post" action="" name="loginform">
					<div class="input-group">
						<p>Username:</p>
						<input type="text" name="username" class="input-text" />
					</div>
					<div class="input-group">
						<p>Password:</p>
						<input type="password" name="password" class="input-text" />
					</div>
					<div class="input-group">
						<input type="submit" name="btnSubmit" value="Masuk" class="btn" />
					</div>
				</form>
				<div>Waktu sekarang : <span id="jam"></span></div><br />
				<div><a href="../">Ke halaman depan</a></div><br />
				<div class="copy">
				Copyright &copy; 2016 All Rights Reserved<br />
				Didesain dan dikembangkan oleh TagConn Team
				</div>
			</div>
		</div>
		<script>
			getTime();
				function _(el) {
					return document.getElementById(el);
				}
				function checkDig(time) {
					str = time.toString();
					if(str.length < 2) {
						return "0"+str;
					} else {
					  return str;
					}
				}
				function getTime() {
					var time = new Date(),
					hour = time.getHours(),
					minute = time.getMinutes(),
					second = time.getSeconds();
					_("jam").innerHTML = checkDig(hour)+":"+checkDig(minute)+":"+checkDig(second);
				}
				setInterval(getTime,1000);
		</script>
	</body>
</html>
	
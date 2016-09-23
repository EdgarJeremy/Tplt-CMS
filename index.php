<?php
require_once "engine/init.php";
$helper->logged_in_protect();
if(isset($_POST["btnSubmit"])) {
	$login = $pengguna->login($_POST["username"],$_POST["password"]);
	if($login === true) {
		$helper->buatLog("User Login", "User dengan nama " . $_SESSION["nama_lengkap"] . " berhasil login dengan IP " . $_SERVER["REMOTE_ADDR"]);
		header("location: home");
		exit();
	} else {
		$helper->buatLog("Percobaan Login", "Percobaan login dengan username " . $_POST["username"] . " dan password " . $_POST["password"] . " dengan IP " . $_SERVER["REMOTE_ADDR"]);
		$helper->set_flashdata("red","Periksa ulang username dan password anda! Jika masih tidak bisa, kemungkinan status anda sebagai user sudah diblokir");
		header("location: index");
		exit();
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Login | Tplt CMS</title>
		<link rel="stylesheet" href="css/font-awesome.min.css" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/main.css" />
		<link rel="stylesheet" href="css/jquery.dataTables.min.css" />
		<link rel="icon" href="img/tagconn.png" />
		<script src="js/jquery-3.0.0.min.js"></script>
		<script src="js/jquery.dataTables.js"></script>
		<link type="text/css" href="js/jqueryUI/jquery-ui.min.css" rel="Stylesheet" />
		<script type="text/javascript" src="js/jqueryUI/jquery-ui.min.js"></script>
		<?php $tema->ambilTemaAktif("back");?>
	</head>
	<body class="login-body" onload="loginform.username.focus()">
		<?php $helper->get_top_notif();?>
		<div class="container">
			<div class="centered">
				<div class="paper1">
				</div>
				<div class="paper2">
				</div>
				<div class="contain card" id="login-box">
					<div class="head">
						<div class="icn">
							<i class="fa fa-sign-in fa-lg"></i>
						</div>
						<h1>User Login</h1><hr />
						<p>Masukkan username dan password untuk verifikasi hak akses</p>
					</div>
					<form action="" method="post">
						<div class="input">
							<div>
								<i class="fa fa-user fa-lg"></i>
								<input type="text" name="username" class="login-input" placeholder="Username" required/><br />
							</div>
							<div>
								<i class="fa fa-lock fa-lg"></i>
								<input type="password" name="password" class="login-input" placeholder="Password" required/>
							</div>
						</div>
						<div class="input-group">
							<button type="submit" name="btnSubmit" class="btn blue" ><i class="fa fa-sign-in fa-lg"></i>&nbsp;Masuk</button>
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
		</div>
		<script>
			getTime();
			if($("#alert")) {
				$("#alert").slideDown(500);
				setInterval(function(){
					$("#alert").slideUp(500);
				},5000);
			}
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

<?php
require_once "engine/init.php";
$helper->logged_out_protect();

/*---Proses---*/
if(isset($_POST["btnSubmit"])) {
	$tambah = $pengguna->tambah($_POST["nama_lengkap"],$_POST["username"],$_POST["password"],$_POST["email"],$_POST["level"]);
	if($tambah === true) {
		$helper->buatLog("Penambahan User","User dengan nama ".$_POST["nama_lengkap"]." ditambah oleh ".$_SESSION["nama_lengkap"]);
		$helper->set_flashdata("green","Pengguna dengan nama ".$_POST["nama_lengkap"]." berhasil ditambah!");
	} else {
		$helper->buatLog("Percobaan Tambah User","User dengan nama ".$_SESSION["nama_lengkap"]." gagal menambahkan user");
		$helper->set_flashdata("red","Terjadi kesalahan saat menambah pengguna!");
	}
	header("location: tambahpengguna");
	exit();
}

$menu = $helper->tentukan_menu_aktif("tambahpengguna");
$title = "Tambah Pengguna - Administrator";
include "frames/menu.php";
?>

			<div class="content">
				<?php $helper->get_notif();?>
				<div class="main-box">
					<div class="header">
						<h1>Tambah Pengguna</h1>
					</div>
					<div class="contain card">
						<form action="" method="post" class="inside">
							<div class="input-group">
								<p><b>Nama Lengkap : </b></p>
								<input type="text" class="input-text" name="nama_lengkap" required/>
							</div>
							<div class="input-group">
								<p><b>Username : </b></p>
								<input type="text" class="input-text" name="username" required/>
							</div>
							<div class="input-group">
								<p><b>Password : </b></p>
								<input type="text" class="input-text" name="password" required/>
							</div>
							<div class="input-group">
								<p><b>Email : </b></p>
								<input type="email" class="input-text" name="email" required/>
							</div>
							<div class="input-group">
								<p><b>Level : </b></p>
								<select name="level" class="input-text" required>
									<option value="">--Pilih--</option>
									<option value="general">General User</option>
									<option value="admin">Administrator</option>
								</select>
							</div>
							<div class="input-group">
								<input type="submit" name="btnSubmit" class="btn" value="Register"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				$("#alert").on("click",function(){
					$(this).fadeOut(100);
				});
			});
		</script>

<?php include "frames/footer.php";?>

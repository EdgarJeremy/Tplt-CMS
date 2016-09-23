<?php
require_once "engine/init.php";
$helper->logged_out_protect();

/*---Proses---*/
if(isset($_POST["btnSubmit"])) {
	$tambah = $agenda->tambah($_POST["judul"],$_POST["tempat"],$_POST["tanggal"],$_POST["mulai"],$_POST["selesai"],$_POST["deskripsi"]);
	if($tambah === true) {
		$helper->set_flashdata("green","Agenda berhasil ditambah!");
	} else {
		$helper->set_flashdata("red","Terjadi kesalahan saat menambah agenda!");
	}
	header("location: tambahagenda");
	exit();
}
$menu = $helper->tentukan_menu_aktif("","agendaChild","tambahagenda");
$title = "Tambah Agenda - Administrator";
include "frames/menu.php";
?>
			<div class="content">
				<?php $helper->get_notif();?>
				<div class="main-box">
					<div class="header">
						<h1>Tambah Agenda</h1>
					</div>
					<div class="contain card">
						<form action="" method="post" class="inside">
							<div class="input-group">
								<p><b>Judul : </b></p>
								<input type="text" class="input-text" name="judul" />
							</div>
							<div class="input-group">
								<p><b>Tempat Pelaksanaan : </b></p>
								<input type="text" class="input-text" name="tempat" />
							</div>
							<div class="input-group">
								<p><b>Tanggal : </b></p>
								<input type="date" class="input-text" name="tanggal" />
							</div>
							<div class="input-group">
								<p><b>Jam Mulai : </b></p>
								<input type="time" class="input-text" name="mulai" />
							</div>
							<div class="input-group">
								<p><b>Jam Selesai : </b></p>
								<input type="time" class="input-text" name="selesai" />
							</div>
							<div class="input-group">
								<p><b>Deskripsi : </b></p>
								<textarea class="input-text" name="deskripsi" col="300" rows="10"></textarea>
							</div>
							<div class="input-group">
								<input type="submit" name="btnSubmit" value="Posting" class="btn" />
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

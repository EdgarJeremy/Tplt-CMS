<?php
require_once "engine/init.php";
$helper->logged_out_protect();

/*---Proses---*/
if(isset($_POST["btnSubmit"])) {
	$post = $berita->tambah($_POST["judul"],$_FILES["gambar"],$_POST["isi"]);
	if($post === true) {
		$helper->set_flashdata("green","Berita berhasil ditambah!");
		$helper->buatLog("Penambahan Berita","Berita dengan judul ".$_POST["judul"]." oleh ".$_SESSION["nama_lengkap"]);
	} else {
		$helper->set_flashdata("red","Terjadi kesalahan saat menambah berita!");
	}
	header("location: tambahberita");
	exit();
}
$menu = $helper->tentukan_menu_aktif("","beritaChild","tambahberita");
$title = "Tambah Berita - Administrator";
include "frames/menu.php";
?>

		<div class="content">
			<?php $helper->get_notif();?>
			<div class="main-box">
				<div class="header">
					<h1>Tambah Berita</h1>
				</div>
				<div class="contain card">
					<form action="" method="post" class="inside" enctype="multipart/form-data">
						<div class="input-group">
							<p><b>Judul : </b></p>
							<input type="text" class="input-text" name="judul" required/>
						</div>
						<div class="input-group">
							<p><b>Gambar : </b></p><br />
							<div id="picts"><input type="file" name="gambar[]" required/></div>
						</div>
						<div class="input-group">
							<button type="button" id="kurang" class="btn red"><i class="fa fa-minus fa-lg"></i></button><button type="button" id="tambah" class="btn blue"><i class="fa fa-plus fa-lg"></i></button>
						</div>
						<div class="input-group">
							<p><b>Isi : </b></p><br />
							<textarea id="isi" name="isi" required></textarea>
						</div>
						<div class="input-group">
							<input type="submit" name="btnSubmit" value="Publish" class="btn" />
						</div>
					</form>
				</div>
			</div>
		</div>
		<script src="ckeditor/ckeditor.js"></script>
		<script>CKEDITOR.replace("isi");</script>
		<script>
			$(document).ready(function(){
				var elemenBaru = "<input type='file' name='gambar[]' required/>";

				$("#tambah").on("click",function(){
					if($("#picts input").length != 4) {
						$("#picts").append(elemenBaru);
					}
				});
				$("#kurang").on("click",function(){
					if($("#picts input").length > 1) {
						$("input:last-child",$("#picts")).remove();
					}
				});
				$("#alert").on("click",function(){
					$(this).fadeOut(100);
				});
			});
		</script>

<?php include "frames/footer.php";?>

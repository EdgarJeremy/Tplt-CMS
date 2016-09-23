<?php
require_once "engine/init.php";
$helper->logged_out_protect();

/*---Proses---*/
if(isset($_POST["btnSubmit"])) {
	$upload = $gallery->tambah($_FILES["gambar"],$_POST["deskripsi"]);
	if($upload === true) {
		$helper->buatLog("Penambahan Foto","User dengan nama ".$_SESSION["nama_lengkap"]." menambahkan foto dengan nama file ".$_FILES["gambar"]["name"]." dan ukuran file gambar ".$_FILES["gambar"]["size"]);
		$helper->set_flashdata("green",count($_POST["deskripsi"])." foto berhasil ditambah!");
	} else {
		$helper->set_flashdata("red","Terjadi kesalahan saat menambah Foto!");
	}
	header("location: tambahfoto");
	exit();
}
$menu = $helper->tentukan_menu_aktif("","galleryChild","tambahfoto");
$title = "Tambah Gallery - Administrator";
include "frames/menu.php";
?>

			<div class="content">
				<?php $helper->get_notif();?>
				<div class="main-box">
					<div class="header">
						<h1>Tambah Foto</h1>
					</div>
					<div class="contain card">
						<form action="" method="post" class="inside" enctype="multipart/form-data">
							<div id="wrap">
								<div class="input-group">
									<p><b>Caption : </b></p>
									<input type="text" name="deskripsi[]" class="input-text" required />
								</div>
								<div class="input-group">
									<p><b>File : </b></p><br />
									<input type="file" name="gambar[]" required/>
								</div>
							</div>
							<div class="input-group">
								<button type="button" id="kurang" class="btn red"><i class="fa fa-minus fa-lg"></i></button><button type="button" id="tambah" class="btn blue"><i class="fa fa-plus fa-lg"></i></button>
							</div>
							<div class="input-group">
								<input type="submit" name="btnSubmit" value="Upload" class="btn" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				var elemenBaru = "<div class='input-group'><p><b>Caption : </b></p><input type='text' name='deskripsi[]' class='input-text' required/></div><div class='input-group'><p><b>File : </b></p><br /><input type='file' name='gambar[]' required/></div>";

				$("#tambah").on("click",function(){
					$("#wrap").append(elemenBaru);
				});
				$("#kurang").on("click",function(){
					if($("#wrap div").length > 2) {
						$("div:last-child",$("#wrap")).remove();
						$("div:last-child",$("#wrap")).remove();
					}
				});
				$("#alert").on("click",function(){
					$(this).fadeOut(100);
				});
			});
		</script>

<?php include "frames/footer.php";?>

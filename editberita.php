<?php
require_once "engine/init.php";
$helper->logged_out_protect();

/*---Proses---*/
if(isset($_POST["btnSubmit"])) {
	$update = $berita->update($_POST["berita"],$_POST["judul"],$_POST["isi"]);
	if($update === true) {
		$helper->set_flashdata("green","Berita berhasil diedit!");
	} else {
		$helper->set_flashdata("red","Berita gagal diedit!");
	}
	header("location: editberita");
	exit();
}
$menu = $helper->tentukan_menu_aktif("","beritaChild","editberita");
$title = "Edit Berita - Administrator";
include "frames/menu.php";
?>

		<div class="content">
			<?php $helper->get_notif();?>
			<div class="main-box">
				<div class="header">
					<h1>Edit Berita</h1>
				</div>
				<div class="contain card">
					<form action="" method="post" class="inside">
						<div class="input-group">
							<p><b>Pilih Berita : </b></p>
							<select name="berita" class="input-text" id="pilih" required>
								<option value="">--Pilih--</option>
								<?php
								$data = $berita->ambilBerdasarkanUser($_SESSION["idusers"]);
								if($data != false):
								foreach($data as $news):
								?>
								<option value="<?php echo $news["idberita"];?>"><?php echo $news["judul"];?></option>
								<?php endforeach;endif;?>
							</select>
						</div>
						<div class="input-group">
							<p><b>Judul : </b></p><br />
							<input type="text" name="judul" id="judul" class="input-text" required/>
						</div>
						<div class="input-group">
							<p><b>Isi : </b></p>
							<textarea id="isi" name="isi"></textarea>
						</div>
						<div class="input-group">
							<input type="submit" name="btnSubmit" value="Update" class="btn" />
						</div>
					</form>
				</div>
			</div>
		</div>
		<script src="ckeditor/ckeditor.js"></script>
		<script>CKEDITOR.replace("isi")</script>
		<script>
			$(document).ready(function(){

				$("#pilih").on("change",function(){
					$.ajax({
						method : "get",
						url : "engine/ajaxAmbilBerita",
						data : {
							id : $(this).val()
						},
						success : function(response) {
							var data = JSON.parse(response);
							//console.log(data);
							$("#judul").val(data.judul);
							CKEDITOR.instances["isi"].setData(data.isi);
						}
					});
				});
				$("#alert").on("click",function(){
					$(this).fadeOut(100);
				});
			});
		</script>
<?php include "frames/footer.php";?>

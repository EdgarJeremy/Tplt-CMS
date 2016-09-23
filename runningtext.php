<?php
require_once "engine/init.php";
$helper->logged_out_protect();

/*--- Proses ---*/
if(isset($_POST["btnSubmit"])) {
	$tambah = $infoweb->editRunningText($_POST["text"]);
	if($tambah === true) {
		$helper->set_flashdata("green","Running text berhasil diupdate!");
	} else {
		$helper->set_flashdata("red","Terjadi kesalahan saat mengupdate running text!");
	}
	header("location: runningtext");
	exit();
}
$menu = $helper->tentukan_menu_aktif("runningtext");
$title = "Edit Running Text - Administrator";
include "frames/menu.php";
?>

			<div class="content">
				<?php $helper->get_notif();?>
				<div class="main-box">
					<div class="header">
						<h1>Edit Running Text</h1>
					</div>
					<div class="contain card">
						<form action="" method="post" class="inside">
							<div id="times">
								<?php
								$data = $infoweb->ambilRunningText();
								foreach($data as $rt):
								?>
								<div class="input-group">
									<p><b>Isi : </b></p>
									<input type="text" class="input-text" name="text[]" value="<?php echo $rt;?>" required/>
								</div>
								<?php endforeach;?>
							</div>
							<div class="input-group">
								<button type="button" id="kurang" class="btn red"><i class="fa fa-minus fa-lg"></i></button><button type="button" id="tambah" class="btn blue"><i class="fa fa-plus fa-lg"></i></button>
							</div>
							<div class="input-group">
								<input type="submit" name="btnSubmit" class="btn" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				var inputBaru = "<div class='input-group'><p><b>Isi : </b></p><input type='text' name='text[]' class='input-text' required /></div>";
				$("#tambah").on("click",function(){
					$("#times").append(inputBaru);
				});
				$("#kurang").on("click",function() {
					if($("#times div").length > 1) {
						$("div:last-child",$("#times")).remove();
					}
				});

				$("#alert").on("click",function(){
					$(this).fadeOut(100);
				});
			});
		</script>
<?php include "frames/footer.php";?>

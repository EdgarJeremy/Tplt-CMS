<?php
require_once "engine/init.php";
$helper->logged_out_protect();
$helper->admin_area_protect();

/*--- Proses ---*/
if(isset($_POST["btnSubmit"])) {
	$update = $tema->update($_POST["tema"],"back");
	if($update === true) {
		$helper->set_flashdata("green","Tema diterapkan!");
	} else {
		$helper->set_flashdata("red","Terjadi kesalahan saat menerapkan tema!");
	}
	header("location: gantitemaback");
	exit();
}
$menu = $helper->tentukan_menu_aktif("","temaChild","gantitemaback");
$title = "Ganti Tema BackEnd - Administrator";
include "frames/menu.php";
?>

			<div class="content">
				<?php $helper->get_notif();?>
				<div class="main-box">
					<div class="header">
						<h1>Ganti Tema (BackEnd)</h1>
					</div>
					<div class="contain card">
						<form action="" method="post" class="inside"/>
							<div class="input-group">
								<p><b>Pilih Tema :</b></p>
								<select name="tema" id="idtema" class="input-text" required>
									<option value="">-- Pilih --</option>
									<?php
									foreach($tema->ambil("back") as $tm):
									?>
									<option value="<?php echo $tm["css"];?>"><?php echo $tm["nama_tema"];?></option>
									<?php endforeach;?>
								</select>
							</div>
							<div class="input-group">
								<input type="submit" class="btn" value="Terapkan" name="btnSubmit" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				var tema = $("#custTema").attr("href");
				$("#idtema").on("change",function(){
					var css = "css/tema/" + $(this).val();
					$("#custTema").prop("href",tema);
					if(css != "") {
						$("#custTema").prop("href",css);
					}
				});

				$("#alert").on("click",function(){
					$(this).fadeOut(100);
				});
			});
		</script>


<?php include "frames/footer.php";?>

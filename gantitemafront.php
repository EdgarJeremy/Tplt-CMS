<?php
require_once "engine/init.php";
$helper->logged_out_protect();
$helper->admin_area_protect();

/*--- Proses ---*/
if(isset($_POST["btnSubmit"])) {
	$update = $tema->update($_POST["tema"],"front");
	if($update === true) {
		$helper->set_flashdata("green","Tema diterapkan!");
	} else {
		$helper->set_flashdata("red","Terjadi kesalahan saat menerapkan tema!");
	}
	header("location: gantitemafront");
	exit();
}

$menu = $helper->tentukan_menu_aktif("","temaChild","gantitemafront");
$title = "Ganti Tema FrontEnd - Administrator";
include "frames/menu.php";
?>

			<div class="content">
				<?php $helper->get_notif();?>
				<div class="main-box">
					<div class="header">
						<h1>Ganti Tema (FrontEnd)</h1>
					</div>
					<div class="contain card">
						<form action="" method="post" class="inside" />
							<div class="input-group">
								<p><b>Pilih Tema : </b></p>
								<select name="tema" class="input-text" required>
									<option value="">-- Pilih --</option>
									<?php foreach($tema->ambil("front") as $tm):?>
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

<?php include "frames/footer.php";?>
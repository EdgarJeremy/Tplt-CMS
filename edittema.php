<?php
require_once "engine/init.php";
$helper->logged_out_protect();

/*--- Proses ---*/

$menu = $helper->tentukan_menu_aktif("","temaChild","edittema");
$title = "Edit Tema - Administrator";
include "frames/menu.php";
?>

			<div class="content">
				<?php $helper->get_notif();?>
				<div class="main-box">
					<div class="header">
						<h1>Edit Tema</h1>
					</div>
					<div class="contain card">
						<form action="" method="post" class="inside">
							<div class="input-group">
								<p><b>Pilih Tema : </b></p>
								<select name="tema" class="input-text" id="pilih">
									<option value="">-- Pilih --</option>
									<?php foreach($tema->ambil() as $tm):?>
									<option value="<?php echo $tm["css"];?>"><?php echo $tm["nama_tema"];?></option>
									<?php endforeach;?>
								</select>
							</div>
							<div class="input-group">
								<p><b>Kode CSS : </b></p>
								<textarea id="css" name="css"></textarea>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script>
		$(document).ready(function(){
			var editor = CodeMirror.fromTextArea(document.getElementById("css"),{
					lineNumbers: true,
					mode:  "css",
					lineWrapping: true,
					allowDropFileTypes: ["css"]
				});
				
			$("#pilih").on("change",function(){
				if($(this).val() != "") {
					$.ajax({
						method: "get",
						url: "engine/ambilIsiCss?css=" + $(this).val(),
						success: function(response) {
							editor.getDoc().setValue(response);
						}
					});
				}
			});
		});
		</script>

<?php include "frames/footer.php";?>
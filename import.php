<?php
require_once "engine/init.php";
$helper->logged_out_protect();
$helper->admin_area_protect();

$menu = $helper->tentukan_menu_aktif("import");
$title = "Import Layout - Administrator";
include "frames/menu.php";
?>

			<div class="content">
				<?php $helper->get_notif();?>
				<div class="main-box">
					<div class="header">
						<h1>Import Layout</h1>
					</div>
					<div class="contain card">
						<div class="informasi">
							Layout untuk Tplt BackEnd harus diupload dengan ekstensi <i>.zip </i> dan sudah mengikuti standar pembuatan layout yang sudah ditentukan. Layout yang sudah diupload akan tercatat di database.<br /> Baca <a href="#">dokumentasi</a> untuk informasi lebih lanjut.
						</div>
						<div class="border">
							<span class="red"></span>
							<span class="blue"></span>
							<span class="green"></span>
							<span class="yellow"></span>
						</div>
						<form action="engine/prosesimport" method="post" enctype="multipart/form-data" class="inside">
							<div class="input-group">
								<p><b>Nama Layout : </b></p>
								<input type="text" class="input-text" name="nama" required/>
							</div>
							<div class="input-group">
								<p><b>Zip File : </b></p><br />
								<input type="file" name="fileZip" required/>
							</div>
							<div class="input-group">
								<input type="submit" name="btnSubmit" value="Import" class="btn" />
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
